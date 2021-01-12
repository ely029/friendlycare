<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Social;
use App\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Hash;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Str;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * @TB: This class is based on the documentation on Stateless HTTP Basic
 * Authentication. Ref:  https://laravel.com/docs/authentication#stateless-http-basic-authentication
 * Note: This class was heavily modified to support managing multiple auth
 * providers using Socialite. Additional documentation are scattered below.
 * Errors follow Stripe's <https://stripe.com/docs/api> API error handling.
 * To get started:
 *
 * (1) Socialite is preinstalled with the boilerplate. Simply configure it: https://laravel.com/docs/socialite#configuration
 * (2) Attach the 'auth.once' middleware to routes.
 */
class AuthenticateOnce
{
    public const SUPPORTED_DRIVERS = [
        self::DRIVER_FACEBOOK,
        self::DRIVER_GOOGLE,
        self::DRIVER_TWITTER,
    ];

    private const DRIVER_FACEBOOK = 'facebook';
    private const DRIVER_GOOGLE = 'google';
    private const DRIVER_TWITTER = 'twitter';

    private const DELIMITER_SPACE = ' ';
    private const DELIMITER_THINKBIT = '<TB>';
    private const DELIMITER_TWITTER = '<TW>';

    private const DOC_URL = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        $authHeader = $request->header('authorization', '');

        if (! Str::contains($authHeader, self::DELIMITER_SPACE)) {
            return abort(
                SymfonyResponse::HTTP_UNAUTHORIZED,
                'You did not provide a token.',
                self::DOC_URL);
        }

        if (stripos($authHeader, 'basic') === 0) {
            return Auth::onceBasic() ? null : $next($request);
        }

        // Example:
        // $authHeader = Facebook asdlkfj823hfalsdfhflaw3h
        // $driver = Facebook
        // $authTokenEncoded = asdlkfj823hfalsdfhflaw3h
        [$driver, $authTokenEncoded] = explode(self::DELIMITER_SPACE, $authHeader);
        $driver = strtolower($driver);

        if (! in_array($driver, self::SUPPORTED_DRIVERS)) {
            return abort(
                SymfonyResponse::HTTP_NOT_IMPLEMENTED,
                "The \"${driver}\" prefix is not supported.",
                self::DOC_URL);
        }

        $authToken = base64_decode($authTokenEncoded);

        if (! Str::contains($authToken, self::DELIMITER_THINKBIT)) {
            return abort(
                SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY,
                'Authentication token does not contain the correct delimiter.',
                self::DOC_URL);
        }

        // Example:
        // $authToken = 12345<TB>TOKEN
        // $clientId = 12345
        // For Twitter, $clientToken = TOKEN<TW>SECRET
        // For others, $clientToken = TOKEN
        [$clientId, $clientToken] = explode(self::DELIMITER_THINKBIT, $authToken);

        // This prevents unnecessary queries to the third-party provider
        if ($this->checkToken($driver, $clientId, $clientToken)) {
            return $next($request);
        }

        return $this->processClientData($driver, $clientId, $clientToken) ? null : $next($request);
    }

    private function checkToken(string $driver, string $clientId, string $clientToken)
    {
        $social = Social::query()
            ->where('driver', $driver)
            ->where('social_id', $clientId)
            ->first();

        if ($social === null) {
            return false;
        }

        return Hash::check($clientToken, $social->token);
    }

    private function processClientData(string $driver, string $clientId, string $clientToken)
    {
        try {
            [$socialId, $socialEmail] = $this->getIdAndEmailFromToken($driver, $clientToken);
        } catch (ClientException $clientException) {
            return abort(
                SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR,
                $clientException->getMessage(),
                self::DOC_URL);
        }

        if ($clientId !== $socialId) {
            return abort(
                SymfonyResponse::HTTP_FORBIDDEN,
                'The IDs provided and extracted do not match.',
                self::DOC_URL);
        }

        $user = $this->getUserOrFail($driver, $socialId, $socialEmail);

        // Note: At this point $user exists so we just log in the user and set
        // the social data.
        // • Update will occur if the user initially signed up using social,
        //   or when updating an old token.
        // • Create will occur if the user initially signed up using email.
        Social::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'driver' => $driver,
                'social_id' => $socialId,
            ],
            ['token' => Hash::make($clientToken)]
        );
    }

    private function getIdAndEmailFromToken(string $driver, string $clientToken)
    {
        $socialite = Socialite::driver($driver);

        $socialId = null;
        $socialEmail = null;

        // Ref: https://laravel.com/docs/socialite#retrieving-user-details
        switch ($driver) {
            case self::DRIVER_FACEBOOK:
                $socialiteUser = $socialite->userFromToken($clientToken);
                $socialId = $socialiteUser->getId();
                $socialEmail = $socialiteUser->getEmail();
                break;

            case self::DRIVER_GOOGLE:
                // There's no need to set actual values google in
                // config/services.php since we're not using Socialite for Google.
                // Note: There is no need for us to exchange the ID token with
                // an access token; We just need to validate it.
                // Ref: https://developers.google.com/identity/sign-in/web/backend-auth#calling-the-tokeninfo-endpoint
                $responseContentsString = (new Client())
                    ->get('https://oauth2.googleapis.com/tokeninfo', [
                        'query' => ['id_token' => $clientToken],
                    ])
                    ->getBody()
                    ->getContents();

                $responseContents = json_decode($responseContentsString);
                $socialId = $responseContents->sub;
                $socialEmail = $responseContents->email;
                break;

            case self::DRIVER_TWITTER:
                if (! Str::contains($clientToken, self::DELIMITER_TWITTER)) {
                    return abort(
                        SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY,
                        'Authentication token does not contain the correct delimiter.',
                        self::DOC_URL);
                }

                [$twitterToken, $twitterSecret] = explode(self::DELIMITER_TWITTER, $clientToken);
                $socialiteUser = $socialite->userFromTokenAndSecret($twitterToken, $twitterSecret);
                $socialId = $socialiteUser->getId();
                $socialEmail = $socialiteUser->getEmail();
                break;

            default:
                throw new Exception("The \"${driver}\" is not supported.");
        }

        return [$socialId, $socialEmail];
    }

    private function getUserOrFail(string $driver, string $socialId, string $email)
    {
        $user = User::query()->where('email', $email)->first();

        if ($user === null) {
            $user = User::query()
                ->whereHas('socials', static function ($query) use ($driver, $socialId) {
                    $query
                        ->where('driver', $driver)
                        ->where('social_id', $socialId);
                })
                ->first();
        }

        // The API client shows the sign up page to the user. Optionally,
        // prefilling the form with data from the Social provider.
        // Note: You MUST create a Social record during user sign up.
        if ($user === null) {
            return abort(
                SymfonyResponse::HTTP_NOT_FOUND,
                'The valid token does not represent an existing user.',
                self::DOC_URL);
        }

        return $user;
    }
}

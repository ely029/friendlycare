<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    const ROUTE_PASSWORD_EMAIL = 'password.email';
    const ROUTE_PASSWORD_REQUEST = 'password.request';
    const ROUTE_PASSWORD_RESET = 'password.reset';
    const ROUTE_PASSWORD_RESET_SUBMIT = 'password.reset';

    const USER_ORIGINAL_PASSWORD = 'secret';
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserCanViewForgotPasswordPage()
    {
        $response = $this->get('/password/reset');
        $response->assertSuccessful();
    }

    public function testUserCanResetPasswordWithValidEmail()
    {
        $faker = Factory::create();
        $token = \Session::token();
        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
            '_token' => $token,
        ]);
        $response = $this->json('POST','/password/email', [
            'email' => $user->email,
            '_token' => $token,
        ]);
        $response->assertSee('We will verify your email address then email your password reset link.');
    }

    public function testUserCanViewPasswordResetPage()
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'password' => bcrypt($faker->unique()->password),
            'role_id' => 1,
            '_token' => \Session::token(),

        ]);

        // @TB: Ignore "Call to an undefined method Illuminate\Contracts\Auth\PasswordBroker::createToken()."
        // @phpstan-ignore-next-line
        $token = \Password::broker()->createToken($user);

        $this
            ->get(route('password.reset', [
                'token' => $token,
            ]))
            ->assertSuccessful();
    }

    public function testUserCanSubmitPasswordReset()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt(self::USER_ORIGINAL_PASSWORD),
            'role_id' => 1,
        ]);

        // @TB: Ignore "Call to an undefined method Illuminate\Contracts\Auth\PasswordBroker::createToken()."
        // @phpstan-ignore-next-line
        $token = \Password::broker()->createToken($user);

        $password = \Str::random();

        $this
            ->followingRedirects()
            ->from(route(self::ROUTE_PASSWORD_RESET, [
                'token' => $token,
            ]))
            ->post('/password/reset', [
                'token' => $token,
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password,
            ])
            ->assertSuccessful();
    }
}

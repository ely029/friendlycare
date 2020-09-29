<?php

namespace Tests\Feature\Api\Users;

use App\FcmRegistrationToken;
use App\Http\Clients\FcmClient;
use App\Role;
use App\User;
use Faker\Factory;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class FcmRegsitrationTokensControllerDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testRemoveTokenRetainsNotificationKey()
    {
        $faker = Factory::create();

        [$user, $token, $requestHeaders, $requestData] = $this->arrangeSuccessfulTest();

        $user->fcm_notification_key = $faker->uuid;
        $user->save();

        // Remaining token will retain notification key
        factory(FcmRegistrationToken::class)->create([
            'user_id' => $user->id,
        ]);

        $this->mock(FcmClient::class, function ($mock) use ($user, $requestData) {
            $mock
                ->shouldReceive('removeDevice')
                ->once()
                ->with(
                    Mockery::on(function ($argument) use ($user) {
                        return $argument->id === $user->id;
                    }),
                    $requestData['registration_id']
                )
                ->andReturn($user->fcm_notification_key);
        });

        $response = $this
            ->deleteJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertNoContent();

        $user->refresh();

        $this->assertNotNull($user->fcm_notification_key);
        $this->assertDatabaseMissing('fcm_registration_tokens', [
            'id' => $token->id,
        ]);
    }

    // Ref: https://firebase.google.com/docs/cloud-messaging/http-server-ref#device-group-management
    public function testRemoveAllTokensRemovesNotificationKey()
    {
        $faker = Factory::create();

        [$user, $token, $requestHeaders, $requestData] = $this->arrangeSuccessfulTest();

        $user->fcm_notification_key = $faker->uuid;
        $user->save();

        $this->mock(FcmClient::class, function ($mock) use ($user, $requestData) {
            $mock
                ->shouldReceive('removeDevice')
                ->once()
                ->with(
                    Mockery::on(function ($argument) use ($user) {
                        return $argument->id === $user->id;
                    }),
                    $requestData['registration_id']
                )
                ->andReturn($user->fcm_notification_key);
        });

        $response = $this
            ->deleteJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertNoContent();

        $user->refresh();

        $this->assertNull($user->fcm_notification_key);
        $this->assertDatabaseMissing('fcm_registration_tokens', [
            'id' => $token->id,
        ]);
    }

    public function testTokenMustBeAuthorized()
    {
        [$user, $token, $requestHeaders, $requestData] = $this->arrangeSuccessfulTest();

        $response = $this
            ->deleteJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
            );

        $response->assertUnauthorized();

        $this->assertDatabaseHas('fcm_registration_tokens', [
            'id' => $token->id,
        ]);
    }

    public function testTokenIsForbiddenForOtherUser()
    {
        $role = factory(Role::class)->create();

        [$user, $token, $requestHeaders, $requestData] = $this->arrangeSuccessfulTest();
        $user2 = factory(User::class)->create([
            'password' => Hash::make(Str::random()),
            'role_id' => $role->id,
        ]);

        $response = $this
            ->deleteJson(
                "/api/users/{$user2->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('fcm_registration_tokens', [
            'id' => $token->id,
        ]);
    }

    public function testTokenIsUnprocessableEntityWithoutRequiredFields()
    {
        [$user, $token, $requestHeaders, $requestData] = $this->arrangeSuccessfulTest();
        $requestData['registration_id'] = null;

        $response = $this
            ->deleteJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['registration_id']);

        $this->assertDatabaseHas('fcm_registration_tokens', [
            'id' => $token->id,
        ]);
    }

    public function testTokenIsUnprocessableEntityWithoutStringFields()
    {
        [$user, $token, $requestHeaders, $requestData] = $this->arrangeSuccessfulTest();
        $requestData['registration_id'] = 1;

        $response = $this
            ->deleteJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['registration_id']);

        $this->assertDatabaseHas('fcm_registration_tokens', [
            'id' => $token->id,
        ]);
    }

    public function testTokenIsUnprocessableEntityWithoutExistingFields()
    {
        [$user, $token, $requestHeaders, $requestData] = $this->arrangeSuccessfulTest();
        $requestData['registration_id'] = 'does not exist';

        $response = $this
            ->deleteJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['registration_id']);

        $this->assertDatabaseHas('fcm_registration_tokens', [
            'id' => $token->id,
        ]);
    }

    private function arrangeSuccessfulTest()
    {
        $role = factory(Role::class)->create();

        $password = Str::random(8);
        $user = factory(User::class)->create([
            'password' => Hash::make($password),
            'role_id' => $role->id,
        ]);

        $apiToken = base64_encode("{$user->email}:${password}");
        $requestHeaders = [
            'Authorization' => "Basic ${apiToken}",
        ];

        $token = factory(FcmRegistrationToken::class)->create([
            'user_id' => $user->id,
        ]);

        $requestData = [
            'registration_id' => $token->registration_id,
        ];

        return [$user, $token, $requestHeaders, $requestData];
    }
}

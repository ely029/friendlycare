<?php

namespace Tests\Feature\Api\Users;

use App\FcmRegistrationToken;
use App\Http\Clients\FcmClient;
use App\Role;
use App\User;
use DB;
use Faker\Factory;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class FcmRegsitrationTokensControllerStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testNewTokenSavesNotificationKey()
    {
        $faker = Factory::create();
        $notificationKey = $faker->uuid;

        [$user, $requestHeaders, $requestData, $responseData] = $this->arrangeSuccessfulTest();

        $this->mock(FcmClient::class, function ($mock) use ($user, $notificationKey, $requestData) {
            $mock
                ->shouldReceive('addDevice')
                ->once()
                ->with(
                    Mockery::on(function ($argument) use ($user) {
                        return $argument->id === $user->id;
                    }),
                    $requestData['registration_id']
                )
                ->andReturn($notificationKey);
        });

        $response = $this
            ->postJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertCreated();
        $response->assertJson($responseData);

        $user->refresh();

        $this->assertEquals($notificationKey, $user->fcm_notification_key);
        $this->assertDatabaseHas('fcm_registration_tokens', $responseData);
    }

    public function testNewTokenRemovesOldestTokenWhenMaxedOut()
    {
        $faker = Factory::create();

        [$user, $requestHeaders, $requestData, $responseData] = $this->arrangeSuccessfulTest();
        $notificationKey = $faker->uuid;

        for ($i = 1; $i <= FcmClient::DEVICE_LIMIT; $i++) {
            factory(FcmRegistrationToken::class)->create([
                'user_id' => $user->id,
            ]);
        }

        $oldestToken = FcmRegistrationToken::orderBy('created_at', 'ASC')->first();

        $this->mock(FcmClient::class, function ($mock) use ($user, $notificationKey, $requestData, $oldestToken) {
            $mock
                ->shouldReceive('removeDevice')
                ->once()
                ->with(
                    Mockery::on(function ($argument) use ($user) {
                        return $argument->id === $user->id;
                    }),
                    $oldestToken->registration_id
                )
                ->andReturn($notificationKey);
            $mock
                ->shouldReceive('addDevice')
                ->once()
                ->with(
                    Mockery::on(function ($argument) use ($user) {
                        return $argument->id === $user->id;
                    }),
                    $requestData['registration_id']
                )
                ->andReturn($notificationKey);
        });

        $response = $this
            ->postJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertCreated();
        $response->assertJson($responseData);

        $this->assertDatabaseHas('fcm_registration_tokens', $responseData);
        $this->assertDatabaseMissing('fcm_registration_tokens', [
            'id' => $oldestToken->id,
        ]);
    }

    public function testNewTokenSavesEvenIfAnotherUserHasTheSameToken()
    {
        [$otherUser, $otherRequestHeaders, $otherRequestData, $otherResponseData] = $this->arrangeSuccessfulTest();
        factory(FcmRegistrationToken::class)->create([
            'user_id' => $otherResponseData['user_id'],
            'registration_id' => $otherRequestData['registration_id'],
        ]);

        $faker = Factory::create();
        $notificationKey = $faker->uuid;

        [$user, $requestHeaders, $requestData, $responseData] = $this->arrangeSuccessfulTest();
        $requestData['registration_id'] = $otherRequestData['registration_id'];
        $responseData['registration_id'] = $otherResponseData['registration_id'];

        $this->mock(FcmClient::class, function ($mock) use ($user, $notificationKey, $requestData) {
            $mock
                ->shouldReceive('addDevice')
                ->once()
                ->with(
                    Mockery::on(function ($argument) use ($user) {
                        return $argument->id === $user->id;
                    }),
                    $requestData['registration_id']
                )
                ->andReturn($notificationKey);
        });

        $response = $this
            ->postJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertCreated();
        $response->assertJson($responseData);

        $user->refresh();

        $this->assertEquals($notificationKey, $user->fcm_notification_key);
        $this->assertDatabaseHas('fcm_registration_tokens', $responseData);
    }

    public function testTokenMustBeAuthorized()
    {
        [$user, $requestHeaders, $requestData, $responseData] = $this->arrangeSuccessfulTest();

        $response = $this
            ->postJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
            );

        $response->assertUnauthorized();

        $this->assertDatabaseMissing('fcm_registration_tokens', $responseData);
    }

    public function testTokenIsForbiddenForOtherUser()
    {
        $role = factory(Role::class)->create();

        [$user, $requestHeaders, $requestData, $responseData] = $this->arrangeSuccessfulTest();
        $user2 = factory(User::class)->create([
            'password' => Hash::make(Str::random()),
            'role_id' => $role->id,
        ]);

        $response = $this
            ->postJson(
                "/api/users/{$user2->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertForbidden();

        $this->assertDatabaseMissing('fcm_registration_tokens', $responseData);
    }

    public function testTokenIsUnprocessableEntityWithoutRequiredFields()
    {
        [$user, $requestHeaders, $requestData, $responseData] = $this->arrangeSuccessfulTest();
        $requestData['registration_id'] = null;

        $response = $this
            ->postJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['registration_id']);

        $this->assertDatabaseMissing('fcm_registration_tokens', $responseData);
    }

    public function testTokenIsUnprocessableEntityWithoutStringFields()
    {
        [$user, $requestHeaders, $requestData, $responseData] = $this->arrangeSuccessfulTest();
        $requestData['registration_id'] = 1;

        $response = $this
            ->postJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['registration_id']);

        $this->assertDatabaseMissing('fcm_registration_tokens', $responseData);
    }

    public function testTokenIsUnprocessableEntityWithoutUniqueFields()
    {
        [$user, $requestHeaders, $requestData, $responseData] = $this->arrangeSuccessfulTest();
        factory(FcmRegistrationToken::class)->create([
            'user_id' => $responseData['user_id'],
            'registration_id' => $requestData['registration_id'],
        ]);

        $response = $this
            ->postJson(
                "/api/users/{$user->id}/fcm_registration_tokens",
                $requestData,
                $requestHeaders,
            );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['registration_id']);

        $this->assertEquals(1, DB::table('fcm_registration_tokens')->where($responseData)->count());
    }

    private function arrangeSuccessfulTest()
    {
        $requestDataFaker = Factory::create();

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

        $requestData = [
            'registration_id' => $requestDataFaker->uuid,
        ];

        $responseData = [
            'user_id' => $user->id,
            'registration_id' => $requestData['registration_id'],
        ];

        return [$user, $requestHeaders, $requestData, $responseData];
    }
}

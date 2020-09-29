<?php

declare(strict_types=1);

namespace App\Http\Clients;

use App\Notifications\Messages\FcmMessage;
use App\User;
use Closure;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class FcmClient
{
    // Ref: https://firebase.google.com/docs/cloud-messaging/js/device-group
    public const DEVICE_LIMIT = 18; // Should be 20 but we inc. error padding

    private const URL = 'https://fcm.googleapis.com/fcm';

    private const NO_VALID_REGISTRATION_IDS_MESSAGE = 'no valid registration ids';
    private const NOTIFICATION_KEY_NOT_FOUND_MESSAGE = 'notification_key not found';

    private $headers;
    private $notificationKeyNamePrefix;

    public function __construct()
    {
        $this->notificationKeyNamePrefix = config('boilerplate.firebase.notification_key_name_prefix');

        if (in_array($this->notificationKeyNamePrefix, [null, ''])) {
            throw new Exception('`notification_key_name` prefix must not be empty.');
        }

        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'key=' . config('boilerplate.firebase.server_key'),
            'project_id' => config('boilerplate.firebase.sender_id'),
        ];
    }

    public function retrieveNotificationKey(User $user)
    {
        try {
            $response = (new Client())->request(
                'GET',
                self::URL . '/notification',
                [
                    'headers' => $this->headers,
                    'query' => [
                        'notification_key_name' => $this->notificationKeyNamePrefix . '_users-' . $user->id,
                    ],
                ]
            );

            return json_decode((string) $response->getBody())->notification_key;
        } catch (ClientException $clientException) {
            return $this->handleErrors([self::NOTIFICATION_KEY_NOT_FOUND_MESSAGE], $clientException, static function () {
                return null;
            });
        }
    }

    public function addDevice(User $user, string $registrationId)
    {
        try {
            if (
                $user->fcm_notification_key === null
                && $this->retrieveNotificationKey($user) === null
            ) {
                return $this->createDeviceGroup($user, $registrationId);
            }

            $response = (new Client())->request(
                'POST',
                self::URL . '/notification',
                [
                    'headers' => $this->headers,
                    'json' => [
                        'operation' => 'add',
                        'notification_key_name' => $this->notificationKeyNamePrefix . '_users-' . $user->id,
                        'notification_key' => $user->fcm_notification_key,
                        'registration_ids' => [$registrationId],
                    ],
                ]
            );

            return json_decode((string) $response->getBody())->notification_key;
        } catch (ClientException $clientException) {
            return $this->handleErrors([self::NOTIFICATION_KEY_NOT_FOUND_MESSAGE], $clientException, function () use ($user, $registrationId) {
                return $this->createDeviceGroup($user, $registrationId);
            });
        }
    }

    public function removeDevice(User $user, string $registrationId)
    {
        try {
            $response = (new Client())->request(
                'POST',
                self::URL . '/notification',
                [
                    'headers' => $this->headers,
                    'json' => [
                        'operation' => 'remove',
                        'notification_key_name' => $this->notificationKeyNamePrefix . '_users-' . $user->id,
                        'notification_key' => $user->fcm_notification_key,
                        'registration_ids' => [$registrationId],
                    ],
                ]
            );

            return json_decode((string) $response->getBody())->notification_key;
        } catch (ClientException $clientException) {
            return $this->handleErrors([
                self::NO_VALID_REGISTRATION_IDS_MESSAGE,
                self::NOTIFICATION_KEY_NOT_FOUND_MESSAGE,
            ], $clientException, static function () {
                return null;
            });
        }
    }

    public function sendMessage(FcmMessage $message)
    {
        $response = (new Client())->request(
            'POST',
            self::URL . '/send',
            [
                'headers' => collect($this->headers)->forget('project_id')->toArray(),
                'json' => $message->toArray(),
            ],
        );

        return json_decode((string) $response->getBody())->success > 0;
    }

    private function createDeviceGroup(User $user, string $registrationId)
    {
        $response = (new Client())->request(
            'POST',
            self::URL . '/notification',
            [
                'headers' => $this->headers,
                'json' => [
                    'operation' => 'create',
                    'notification_key_name' => $this->notificationKeyNamePrefix . '_users-' . $user->id,
                    'registration_ids' => [$registrationId],
                ],
            ]
        );

        return json_decode((string) $response->getBody())->notification_key;
    }

    private function handleErrors($messages, ClientException $clientException, Closure $closure)
    {
        if ($clientException->getCode() === Response::HTTP_BAD_REQUEST) {
            $body = json_decode((string) $clientException->getResponse()->getBody());

            if ($body !== null && in_array($body->error, $messages)) {
                return $closure();
            }
        }

        throw $clientException;
    }
}

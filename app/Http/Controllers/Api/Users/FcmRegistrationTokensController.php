<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\FcmRegistrationToken;
use App\Http\Clients\FcmClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\FcmRegistrationTokens\DestroyRequest;
use App\User;
use DB;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Users > FCM Registration Tokens
 *
 * A Firebase Cloud Messaging (FCM) Registration Token is used to register
 * devices to a single device group.
 *
 * Related guides: [Send messages to device groups](https://firebase.google.com/docs/cloud-messaging/js/device-group) and [Access the registration token](https://firebase.google.com/docs/cloud-messaging/js/client#access_the_registration_token).
 */
class FcmRegistrationTokensController extends Controller
{
    /**
     * Add a device
     *
     * We recommend calling this API whenever [the user logs in](https://firebase.google.com/docs/cloud-messaging/js/client#retrieve-the-current-registration-token)
     * and [a new token is generated](https://firebase.google.com/docs/cloud-messaging/js/client#monitor-token-refresh).
     *
     * A device group will automatically be created for the provided `{user}`.
     * This automatically tracks devices and adds new devices to existing device
     * groups.
     *
     * **NOTE:** The oldest device of a device group with ~20 members will be
     * removed.
     *
     * @authenticated
     * @urlParam user required The ID of the user. Example: 1
     * @bodyParam registration_id string required The registration token. Example: fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo
     * @response 201 {
     *     "id": 1,
     *     "user_id": 1,
     *     "registration_id": "fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo",
     *     "created_at": "2020-03-18 06:35:22",
     *     "updated_at": "2020-03-18 06:35:22"
     * }
     */
    public function store($request, FcmClient $fcm, User $user)
    {
        $registrationId = $request['token'];

        $this->removeOldTokens($user, $fcm);
        $user->fcm_notification_key = $fcm->addDevice($user, $registrationId);
        $user->save();

        $token = new FcmRegistrationToken();
        $token->registration_id = $registrationId;
        $user->fcmRegistrationTokens()->save($token);

        return response($token->toArray(), Response::HTTP_CREATED);
    }

    /**
     * Remove a device
     *
     * We recommend calling this API whenever the user logs out so that:
     * * the user will not receive a notification on that device, and
     * * the device group will not reach its ~20 member limit.
     *
     * The device group will automatically be deleted for the provided `{user}`
     * if there are no more members, but this should not impact you.
     *
     * @authenticated
     * @urlParam user required The ID of the user. Example: 1
     * @bodyParam registration_id string required The registration token. Example: fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo
     * @response 204 ''
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "registration_id": [
     *             "The registration id field is required."
     *         ]
     *     }
     * }
     */
    public function destroy($registrationId, FcmClient $fcm, User $user)
    {
        $token = FcmRegistrationToken::query()
            ->where('registration_id', $registrationId)
            ->first();

        $fcm->removeDevice($user, $token->registration_id);

        $token->delete();

        if ($user->fcmRegistrationTokens()->count() === 0) {
            $user->fcm_notification_key = null;
            $user->save();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function removeOldTokens(User $user, FcmClient $fcm)
    {
        DB::beginTransaction();

        try {
            while ($user->fcmRegistrationTokens()->count() >= FcmClient::DEVICE_LIMIT) {
                $oldestToken = $user
                    ->fcmRegistrationTokens()
                    ->orderBy('created_at')
                    ->first();

                $fcm->removeDevice($user, $oldestToken->registration_id);

                $oldestToken->delete();
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}

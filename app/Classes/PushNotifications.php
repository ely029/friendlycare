<?php

declare(strict_types=1);

namespace App\Classes;

use App\User;
use Illuminate\Support\Facades\DB;

class PushNotifications
{
    /** provider to specific patient */
    public function providerPushNotifications($title, $message, $id)
    {
        $user = DB::table('users')->select('fcm_notification_key')->where('id', $id)->pluck('fcm_notification_key');
        $fcmurl = 'https://fcm.googleapis.com/fcm/send';
        $token = $user[0];
        $notification = [
            'title' => $title,
            'body' => $message,
            'icon' => 'myIcon',
            'sound' => 'defaultSound',
            'priority' => 'high',
            'contentAvailable' => true,
        ];

        $extraNotifications = ['message' => $notification, 'moredata' => 'bb'];

        $fcmNotification = [
            'to' => $token,
            'notification' => $notification,
            'data' => $extraNotifications,
        ];

        $headers = [
            'Authorization: key='.\Config::get('boilerplate.firebase.server_key').'',
            'Content-Type: application/json',
        ];
        $chh = curl_init();
        curl_setopt($chh, CURLOPT_URL, $fcmurl);
        curl_setopt($chh, CURLOPT_POST, true);
        curl_setopt($chh, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, $headers);
        curl_setopt($chh, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($chh);
        curl_close($chh);

        return $result;
    }

    /** patient to staff push notification*/
    public function patientStaffPushNotification($id, $title, $message)
    {
        $user = new User();
        $users = $user->getStaffFCMToken($id);
        $eee = json_decode(json_encode($users), true);
        $count = count($users) - 1;
        for ($fff = 0;$fff <= $count; $fff++) {
            $fcmurl = 'https://fcm.googleapis.com/fcm/send';
            $notification = [
                'title' => $title,
                'body' => $message,
                'icon' => 'myIcon',
                'sound' => 'defaultSound',
                'priority' => 'high',
                'contentAvailable' => true,
            ];
            $extraNotifications = ['message' => $notification, 'moredata' => 'bb'];
            $fcmNotification = [
                'to' => $eee[$fff]['fcm_notification_key'],
                'notification' => $notification,
                'data' => $extraNotifications,
            ];
            $headers = [
                'Authorization: key='.\Config::get('boilerplate.firebase.server_key').'',
                'Content-Type: application/json',
            ];
            $chh = curl_init();
            curl_setopt($chh, CURLOPT_URL, $fcmurl);
            curl_setopt($chh, CURLOPT_POST, true);
            curl_setopt($chh, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, $headers);
            curl_setopt($chh, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($chh);
            curl_close($chh);
            return $result;
        }
    }
}

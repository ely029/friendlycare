<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index($id)
    {
        $dateToday = strtotime(date('Y-m-d'));
        $details = DB::table('survey')->select('date_from_datestring', 'id')->where('date_from_datestring', '>=', $dateToday)->get();
        foreach ($details as $detail) {
            if ($detail->date_from_datestring >= $dateToday) {
                $user = DB::table('users')->select('fcm_notification_key')->where('id', $id)->pluck('fcm_notification_key');
                $fcmurl = 'https://fcm.googleapis.com/fcm/send';
                $token = $user[0];
                $notification = [
                    'title' => 'Survey Posted',
                    'body' => 'There is a Survey Posted',
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
                    'Authorization: key=AAAAhGKDgoo:APA91bGxHrVfvIgku3NIcP7P3EerjE1cE_zHRXp9dVOp8RYkhb3o1Cv5g26R5Lx8vXFZoBCM10-YsSCfyBkxy34ORiqK_hLJjrJcAxnIUOswhJrgxHoOtmTgUca0gXkb4kx_ZkyAEa84',
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
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\EventsNotification;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function index()
    {
        $upcomingEvent = DB::table('events_notification')
            ->select('id', 'title', 'date', 'type')
            ->where('is_approve', 1)
            ->where('type', 1)
            ->where('date_string', '>=', strtotime(date('Y-m-d')))
            ->get();

        $pastEvent = DB::table('events_notification')
            ->select('id', 'title', 'date', 'type')
            ->where('is_approve', 1)
            ->where('type', 1)
            ->where('date_string', '<=', strtotime(date('Y-m-d')))
            ->get();

        $upcomingAnnouncement = DB::table('events_notification')
            ->select('id', 'title', 'date', 'type')
            ->where('is_approve', 1)
            ->where('type', 2)
            ->where('date_string', '>=', strtotime(date('Y-m-d')))
            ->get();

        $pastAnnouncement = DB::table('events_notification')
            ->select('id', 'title', 'date', 'type')
            ->where('is_approve', 1)
            ->where('type', 2)
            ->where('date_string', '<=', strtotime(date('Y-m-d')))
            ->get();

        return view('admin.notifications.index', ['upcomingEvent' => $upcomingEvent, 'pastEvent' => $pastEvent, 'upcomingAnnouncement' => $upcomingAnnouncement, 'pastAnnouncement' => $pastAnnouncement]);
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function postNotification()
    {
        $validator = \Validator::make(request()->all(), [
            'title' => 'required',
            'message' => 'required',
            'type' => 'required',
            'schedule' => 'required',
        ]);

        $mytime = Carbon::now()->timezone('Asia/Manila');

        if ($validator->fails()) {
            return redirect('notification/create')
                ->withErrors($validator)
                ->withInput();
        }
        $request = request()->all();
        if ($request['schedule'] === 'Post Now') {
            if ($request['type'] === '2') {
                $request['is_approve'] = 1;
                $request['date_time_string'] = $mytime->toDateTimeString();
                $request['date_string'] = strtotime(date('Y-m-d'));
                $request['date'] = date('Y-m-d');
                $request['display_type'] = 'Announcements';
                $request['scheduled'] = $request['schedule'];
                $request['schedule'] = 0;
                $request['created_at'] = $mytime->toDateTimeString();
                $request['updated_at'] = $mytime->toDateTimeString();
                EventsNotification::create($request);
                $this->runPushNotification($request);
            } else {
                $request['is_approve'] = 1;
                $request['date_string'] = strtotime(date('Y-m-d'));
                $request['date'] = date('Y-m-d');
                $request['display_type'] = 'Events';
                $request['scheduled'] = $request['schedule'];
                $request['schedule'] = 0;
                $request['created_at'] = $mytime->toDateTimeString();
                $request['updated_at'] = $mytime->toDateTimeString();
                EventsNotification::create($request);
                $this->runPushNotification($request);
            }
        } else {
            if ($request['type'] === 'Scheduled') {
                $request['is_approve'] = 1;
                $request['date_string'] = strtotime($request['date']);
                $request['display_type'] = 'Announcements';
                $request['scheduled'] = $request['schedule'];
                $request['schedule'] = 0;
                $request['created_at'] = $mytime->toDateTimeString();
                $request['updated_at'] = $mytime->toDateTimeString();
                EventsNotification::create($request);
                $this->runPushNotification($request);
            } else {
                $request['is_approve'] = 1;
                $request['date_string'] = strtotime($request['date']);
                $request['display_type'] = 'Events';
                $request['scheduled'] = $request['schedule'];
                $request['schedule'] = 0;
                $request['created_at'] = $mytime->toDateTimeString();
                $request['updated_at'] = $mytime->toDateTimeString();
                EventsNotification::create($request);
                $this->runPushNotification($request);
            }
        }
        return redirect()->action('Admin\NotificationsController@index');
    }

    public function information($id)
    {
        $details = EventsNotification::where('id', $id)->get();

        return view('admin.notifications.information', ['details' => $details]);
    }

    public function edit($id)
    {
        $details = EventsNotification::where('id', $id)->get();

        return view('admin.notifications.edit', ['details' => $details]);
    }

    public function postEdit()
    {
        $request = request()->all();
        if (isset($request['date']) || isset($request['time'])) {
            $request['date_string'] = strtotime($request['date']);
            $mytime = Carbon::now();
            EventsNotification::where('id', $request['id'])->update([
                'title' => $request['title'],
                'message' => $request['message'],
                'type' => $request['type'],
                'scheduled' => $request['schedule'],
                'date' => $request['date'],
                'time' => $request['time'],
                'date_string' => $request['date_string'],
                'created_at' => $mytime->toDateTimeString(),
                'updated_at' => $mytime->toDateTimeString(),
            ]);
        } else {
            EventsNotification::where('id', $request['id'])->update([
                'title' => $request['title'],
                'message' => $request['message'],
                'type' => $request['type'],
                'scheduled' => $request['schedule'],
            ]);
        }

        return redirect()->action('Admin\NotificationsController@index');
    }

    public function delete($id)
    {
        EventsNotification::where('id', $id)->delete();
        return redirect()->action('Admin\NotificationsController@index');
    }

    private function runPushNotification($request)
    {
        if ($request['date_string'] <= strtotime(date('Y-m-d'))) {
            $this->pushNotification();
        }
    }

    private function pushNotification()
    {
        $user = DB::table('users')->select('fcm_notification_key')->where('fcm_notification_key', '<>', null)->get();
        foreach ($user as $users) {
            $fcmurl = 'https://fcm.googleapis.com/fcm/send';
            $token = $users->fcm_notification_key;
            $notification = [
                'title' => 'Events Posted',
                'body' => 'There is a Events Posted',
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
    }
}

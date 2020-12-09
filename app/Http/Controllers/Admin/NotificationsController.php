<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\EventsNotification;
use App\Http\Controllers\Controller;
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

        if ($validator->fails()) {
            return redirect('notification/create')
                ->withErrors($validator)
                ->withInput();
        }

        $request = request()->all();
        if ($request['schedule'] === 'Post Now') {
            if ($request['type'] === '2') {
                $request['is_approve'] = 1;
                $request['date_string'] = strtotime(date('Y-m-d'));
                $request['date'] = date('Y-m-d');
                $request['display_type'] = 'Announcements';
                $request['scheduled'] = $request['schedule'];
                $request['schedule'] = 0;
                EventsNotification::create($request);
            } else {
                $request['is_approve'] = 1;
                $request['date_string'] = strtotime(date('Y-m-d'));
                $request['date'] = date('Y-m-d');
                $request['display_type'] = 'Events';
                $request['scheduled'] = $request['schedule'];
                $request['schedule'] = 0;
                EventsNotification::create($request);
            }
        } else {
            if ($request['type'] === 'Scheduled') {
                $request['is_approve'] = 1;
                $request['date_string'] = strtotime($request['date']);
                $request['display_type'] = 'Announcements';
                $request['scheduled'] = $request['schedule'];
                $request['schedule'] = 0;
                EventsNotification::create($request);
            } else {
                $request['is_approve'] = 1;
                $request['date_string'] = strtotime($request['date']);
                $request['display_type'] = 'Events';
                $request['scheduled'] = $request['schedule'];
                $request['schedule'] = 0;
                EventsNotification::create($request);
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
            EventsNotification::where('id', $request['id'])->update([
                'title' => $request['title'],
                'message' => $request['message'],
                'type' => $request['type'],
                'scheduled' => $request['schedule'],
                'date' => $request['date'],
                'time' => $request['time'],
                'date_string' => $request['date_string'],
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
}

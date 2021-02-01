<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\EventsNotification;
use App\Http\Controllers\Controller;
use App\Survey;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $details = Survey::all();
        return view('admin.survey.index', ['details' => $details]);
    }

    public function create()
    {
        return view('admin.survey.create');
    }

    public function post()
    {
        $request = request()->all();
        $request['date_from_datestring'] = strtotime($request['date_from']);
        $request['date_to_datestring'] = strtotime($request['date_to']);
        Survey::create($request);
        $this->pushNotification();
        $id = DB::table('survey')->select('id')->orderBy('id', 'desc')->pluck('id');

        EventsNotification::create([
            'title' => $request['title'],
            'message' => $request['message'],
            'type' => 6,
            'survey_link' => $request['link'],
            'survey_date_from_string' => $request['date_from_datestring'],
            'survey_date_to_string' => $request['date_to_datestring'],
            'survey_id' => $id[0],
        ]);

        return redirect('/survey/information/'.$id[0]);
    }

    public function information($id)
    {
        $details = Survey::where('id', $id)->get();
        return view('admin.survey.information', ['details' => $details]);
    }

    public function edit($id)
    {
        $details = Survey::where('id', $id)->get();
        return view('admin.survey.edit', ['details' => $details]);
    }

    public function delete($id)
    {
        DB::delete('DELETE FROM survey where id =?', [$id]);
        DB::delete('DELETE FROM events_notification where survey_id =?', [$id]);
        return redirect('survey/list');
    }
    public function postEdit()
    {
        $request = request()->all();
        $request['date_from_datestring'] = strtotime($request['date_from']);
        $request['date_to_datestring'] = strtotime($request['date_to']);
        Survey::where('id', $request['id'])->update([
            'title' => $request['title'],
            'message' => $request['message'],
            'date_from' => $request['date_from'],
            'date_to' => $request['date_to'],
            'date_from_datestring' => $request['date_from_datestring'],
            'date_to_datestring' => $request['date_to_datestring'],
            'link' => $request['link'],
        ]);

        return redirect('survey/information/'.$request['id']);
    }

    private function pushNotification()
    {
        $fcm = [];
        $user = DB::table('users')->select('fcm_notification_key')->where('fcm_notification_key', '<>', null)->get();
        $data = json_decode(json_encode($user), true);
        foreach($data as $datas) {
            $fcm[] = $datas['fcm_notification_key'];
        }
        $fcmurl = 'https://fcm.googleapis.com/fcm/send';
        $token = $fcm;
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

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

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
        $id = DB::table('survey')->select('id')->orderBy('id', 'desc')->pluck('id');

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
        Survey::where('id', $id)->delete();
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
}

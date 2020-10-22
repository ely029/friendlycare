<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\FamilyPlanTypeSubcategories;
use App\Http\Controllers\Controller;
use App\ServiceGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyPlanningMethodController extends Controller
{
    public function index()
    {
        $details = DB::table('family_plan_type_subcategory')
            ->select('name', 'id', 'family_plan_type_id', 'short_name')
            ->where('is_approve', 1)
            ->get();

        return view('admin.familyPlanningMethod.index', ['details' => $details]);
    }

    public function firstPage()
    {
        return view('admin.familyPlanningMethod.create.firstPage');
    }

    public function secondPage()
    {
        return view('admin.familyPlanningMethod.create.secondPage');
    }

    public function thirdPage()
    {
        return view('admin.familyPlanningMethod.create.thirdPage');
    }

    public function createOne(Request $requests)
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'name' => 'required|string|max:255|unique:family_plan_type_subcategory',
            'icon' => 'required',
            'family_plan_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('fpm/create/1')
                ->withErrors($validator)
                ->withInput();
        }

        $icon = $requests->file('icon');
        $destination = public_path('assets/app/img/');
        $icon_url = url('assets/app/img/'.$icon->getClientOriginalName());

        $icon->move($destination, $icon->getClientOriginalName());
        $request['icon_url'] = $icon_url;
        $request['icon'] = $icon->getClientOriginalName();
        FamilyPlanTypeSubcategories::create($request);

        $name = DB::table('family_plan_type_subcategory')->where('name', $request['name'])->pluck('id');
        session(['id' => $name[0]]);

        return redirect('fpm/create/2');
    }

    public function createTwo()
    {
        $request = request()->all();
        $validator = \Validator::make(request()->all(), [
            'description_tagalog' => 'required',
            'description_english' => 'required',
            'how_it_works_english' => 'required',
            'how_it_works_tagalog' => 'required',
            'side_effect_english' => 'required',
            'side_effect_tagalog' => 'required',
            'additional_note_english' => 'required',
            'additional_note_tagalog' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('fpm/create/2')
                ->withErrors($validator)
                ->withInput();
        }

        FamilyPlanTypeSubcategories::where('id', session('id'))->update([
            'description_english' => $request['description_english'],
            'description_filipino' => $request['description_tagalog'],
            'how_it_works_english' => $request['how_it_works_english'],
            'how_it_works_filipino' => $request['how_it_works_tagalog'],
            'side_effect_english' => $request['side_effect_english'],
            'side_effect_filipino' => $request['side_effect_tagalog'],
            'additional_note_english' => $request['additional_note_english'],
            'additional_note_filipino' => $request['additional_note_tagalog'],
        ]);

        return redirect('fpm/create/3');
    }

    public function createThree(Request $request)
    {
        for ($files = 0;$files <= 4;$files++) {
            if (isset($request->file('pics')[$files])) {
                $icon = $request->file('pics')[$files];
                $destination = public_path('/uploads');
                $icon->move($destination, $icon->getClientOriginalName());
                $icon_url = url('uploads/'.$icon->getClientOriginalName());
                ServiceGallery::create([
                    'file_name' => $icon->getClientOriginalName(),
                    'service_id' => session('id'),
                    'file_url' => $icon_url,
                    'value_id' => $files,
                ]);
            }
        }
        FamilyPlanTypeSubcategories::where('id', session('id'))->update([
            'video_link' => $request['video_link'],
        ]);

        FamilyPlanTypeSubcategories::where('id', session('id'))->update([
            'is_approve' => 1,
        ]);

        return redirect('fpm/information/'.session('id'));
    }

    public function information($id)
    {
        $details = FamilyPlanTypeSubcategories::where('id', $id)->with('serviceGalleries')->get();
        return view('admin.familyPlanningMethod.information', ['details' => $details]);
    }

    public function edit($id)
    {
        $details = FamilyPlanTypeSubcategories::where('id', $id)->with('serviceGalleries')->get();
        return view('admin.familyPlanningMethod.editPage', ['details' => $details]);
    }

    public function update(Request $request)
    {
        $requests = request()->all();

        if ($request->file('icon') !== null) {
            $icon = $request->file('icon');
            $destination = public_path('assets/app/img/');
            $icon_url = url('assets/app/img/'.$icon->getClientOriginalName());

            $icon->move($destination, $icon->getClientOriginalName());
            $request['icon_url'] = $icon_url;
            $request['icon_1'] = $icon->getClientOriginalName();
            FamilyPlanTypeSubcategories::where('id', $requests['id'])->update([
                'name' => $requests['name'],
                'short_name' => $requests['short_name'],
                'typical_validity' => $requests['typical_validity'],
                'percent_effective' => $requests['percent_effective'],
                'description_english' => $requests['description_english'],
                'description_filipino' => $requests['description_tagalog'],
                'how_it_works_english' => $requests['how_it_works_english'],
                'how_it_works_filipino' => $requests['how_it_works_tagalog'],
                'side_effect_filipino' => $requests['side_effect_tagalog'],
                'side_effect_english' => $requests['side_effect_english'],
                'additional_note_english' => $requests['additional_note_english'],
                'additional_note_filipino' => $requests['additional_note_tagalog'],
                'icon' => $request['icon_1'],
                'icon_url' => $request['icon_url'],
            ]);
        } else {
            FamilyPlanTypeSubcategories::where('id', $requests['id'])->update([
                'name' => $requests['name'],
                'short_name' => $requests['short_name'],
                'typical_validity' => $requests['typical_validity'],
                'percent_effective' => $requests['percent_effective'],
                'description_english' => $requests['description_english'],
                'description_filipino' => $requests['description_tagalog'],
                'how_it_works_english' => $requests['how_it_works_english'],
                'how_it_works_filipino' => $requests['how_it_works_tagalog'],
                'side_effect_filipino' => $requests['side_effect_tagalog'],
                'side_effect_english' => $requests['side_effect_english'],
                'additional_note_english' => $requests['additional_note_english'],
                'additional_note_filipino' => $requests['additional_note_tagalog'],
            ]);
        }

        return redirect('fpm');
    }

    public function delete($id)
    {
        FamilyPlanTypeSubcategories::where('id', $id)->delete();
        return redirect('/fpm');
    }
}

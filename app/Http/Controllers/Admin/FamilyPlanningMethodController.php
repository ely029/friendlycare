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
            'percent_effective' => 'required|numeric|between:0,99.99',
            'typical_validity' => 'required|numeric|between:0,99.99',
        ]);
        if ($validator->fails()) {
            return redirect('fpm/create/1')
                ->withErrors($validator)
                ->withInput();
        }
        if ($requests['pic_url'] === null) {
            return redirect('fpm/create/1')
                ->withErrors('Icon is Required')
                ->withInput();
        }
        if ($request['family_plan_type_id'] === null) {
            return redirect('fpm/create/1')
                ->withErrors('Family Plan Type Category is required')
                ->withInput();
        }
        $request['icon_url'] = $request['pic_url'];
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
        $requests = request()->all();
        if ($request->file('pics') !== null) {
            if (count($request->file('pics')) > 5) {
                return redirect('fpm/create/3')
                    ->withErrors('Uploading of images are exceeded')
                    ->withInput();
            }
            for ($files = 0;$files <= 4;$files++) {
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
            'video_link' => $requests['video_link'],
        ]);

        FamilyPlanTypeSubcategories::where('id', session('id'))->update([
            'is_approve' => 1,
        ]);

        return redirect('fpm/information/'.session('id'));
    }

    public function information($id)
    {
        $details = DB::table('family_plan_type_subcategory as fpm')
            ->select('fpm.name',
                            'fpm.id',
                            'fpm.icon',
                            'fpm.short_name',
                            'fpm.percent_effective',
                            'fpm.typical_validity',
                            'fpm.description_english',
                            'fpm.description_filipino',
                            'fpm.how_it_works_english',
                            'fpm.how_it_works_filipino',
                            'fpm.side_effect_english',
                            'fpm.side_effect_filipino',
                            'fpm.additional_note_english',
                            'fpm.additional_note_filipino',
                            'fpm.video_link',
                            'fpm.icon_url')
            ->where('fpm.id', $id)
            ->get();

        $serviceGallery = DB::table('service_gallery')
            ->select('service_id', 'file_name', 'file_url')
            ->where('service_id', $id)
            ->get();
        return view('admin.familyPlanningMethod.information', ['details' => $details, 'serviceGalleries' => $serviceGallery]);
    }

    public function edit($id)
    {
        $details = DB::table('family_plan_type_subcategory as fpm')
            ->select('fpm.name',
                            'fpm.id',
                            'fpm.icon',
                            'fpm.short_name',
                            'fpm.percent_effective',
                            'fpm.typical_validity',
                            'fpm.description_english',
                            'fpm.description_filipino',
                            'fpm.how_it_works_english',
                            'fpm.how_it_works_filipino',
                            'fpm.side_effect_english',
                            'fpm.side_effect_filipino',
                            'fpm.additional_note_english',
                            'fpm.additional_note_filipino',
                            'fpm.video_link',
                            'fpm.family_plan_type_id',
                            'fpm.icon_url')
            ->where('fpm.id', $id)
            ->get();

        $serviceGallery = DB::table('service_gallery')
            ->select('service_id', 'file_name', 'file_url', 'id')
            ->where('service_id', $id)
            ->get();
        return view('admin.familyPlanningMethod.editPage', ['details' => $details, 'serviceGallery' => $serviceGallery]);
    }

    public function update(Request $request)
    {
        $requests = request()->all();
        FamilyPlanTypeSubcategories::where('id', $requests['id'])->update([
            'name' => $requests['name'],
            'family_plan_type_id' => $requests['family_plan_type_id'],
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
            'video_link' => $requests['video_link'],
            'icon' => $request['icon_1'],
            'icon_url' => $request['icon_url'],
        ]);
        return redirect('fpm');
    }

    public function delete($id)
    {
        FamilyPlanTypeSubcategories::where('id', $id)->delete();
        return redirect('/fpm');
    }

    public function iconUpload(Request $request)
    {
        $request = request()->all();
        $icon = $request['icon'];
        $destination = public_path('assets/app/img/');
        $icon_url = url('assets/app/img/'.$icon->getClientOriginalName());
        $icon->move($destination, $icon->getClientOriginalName());

        return response()->json($icon_url);
    }

    public function galleryUpload(Request $request)
    {
        $icon = $request->file('file');
        $destination = public_path('/uploads/fpm');
        $icon[0]->move($destination, $icon[0]->getClientOriginalName());
        $icon_url = url('uploads/fpm/'.$icon[0]->getClientOriginalName());
        ServiceGallery::create([
            'file_name' => $icon[0]->getClientOriginalName(),
            'service_id' => session('id'),
            'file_url' => $icon_url,
        ]);
    }

    public function updateGalleryUpload(Request $request)
    {
        $icon = $request->file('file');
        $requests = request()->all();
        $destination = public_path('/uploads/fpm');
        $icon[0]->move($destination, $icon[0]->getClientOriginalName());
        $icon_url = url('uploads/fpm/'.$icon[0]->getClientOriginalName());
        ServiceGallery::create([
            'file_name' => $icon[0]->getClientOriginalName(),
            'service_id' => $requests['fpm'],
            'file_url' => $icon_url,
        ]);
    }

    public function deleteServiceGallery($id, $serviceId)
    {
        ServiceGallery::where('id', $id)->delete();
        return redirect('/fpm/edit/'.$serviceId);
    }
}

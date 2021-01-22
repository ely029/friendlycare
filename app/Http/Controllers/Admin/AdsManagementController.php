<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\AdsManagement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsManagementController extends Controller
{
    public function index()
    {
        $data = AdsManagement::get();
        return view('admin.ads.index', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function uploadImage(Request $request)
    {
        $icon = $request->file('file');
        $destination = public_path('/uploads/ads');
        $icon->move($destination, $icon->getClientOriginalName());
        $icon_url = url('uploads/ads/'.$icon->getClientOriginalName());

        return response($icon_url);
    }

    public function post()
    {
        $request = request()->all();
        $request['image_url'] = $request['ads-image-location'];
        AdsManagement::create($request);
        return redirect('ads/');
    }

    public function filter()
    {
        $request = request()->all();
        $details = DB::table('ads_management')
            ->select('company_name', 'start_date', 'title', 'ad_link', 'id')
            ->whereBetween('start_date', [$request['start_date'], $request['end_date']])
            ->get();

        return view('admin.ads.index', ['data' => $details]);
    }

    public function viewInformation($id)
    {
        $data = DB::table('ads_management')->select('id', 'ad_link', 'start_date', 'end_date', 'image_url')->where('id', $id)->get();
        return view('admin.ads.information', ['data' => $data]);
    }

    public function delete($id)
    {
        AdsManagement::where('id', $id)->delete();
        return redirect('ads/');
    }
}

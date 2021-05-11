<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\AdsManagement;
use App\Exports\AdsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdsManagementController extends Controller
{
    public function index()
    {
        $ads = new AdsManagement();
        $adsDetails = $ads->getAdsDetails();
        return view('admin.ads.index', ['details' => $adsDetails]);
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
        $request['start_date_string'] = strtotime($request['start_date']);
        $request['end_date_string'] = strtotime($request['end_date']);
        AdsManagement::create($request);
        return redirect('ads/');
    }

    public function filter()
    {
        $request = request()->all();
        $ads = new AdsManagement();
        $details = $ads->filter($request);
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        return view('admin.ads.index', ['details' => $details, 'start_date' => $start_date, 'end_date' => $end_date]);
    }

    public function viewInformation($id)
    {
        $ads = new AdsManagement();
        $data = $ads->getViewInformation($id);
        return view('admin.ads.information', ['data' => $data]);
    }

    public function delete($id)
    {
        DB::delete('delete from ads_management where id = ?', [$id]);
        return redirect('ads/');
    }

    public function export()
    {
        $request = request()->all();
        $fileName = 'Ads-Report.csv';
        return Excel::download(new AdsExport($request['start_date'] ?? '0', $request['end_date'] ?? '0'), $fileName);
    }
}

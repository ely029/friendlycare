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
        $data = $ads->getAdsDetails();
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

        return view('admin.ads.index', ['data' => $details]);
    }

    public function viewInformation($id)
    {
        $data = DB::table('ads_management')
            ->select(
                'ads_management.id',
                'ads_management.ad_link',
                'ads_management.start_date',
                'ads_management.end_date',
                'ads_management.image_url')->where('ads_management.id', $id)
            ->get();
        $count_clicks = DB::table('ad_clicks')
            ->select('ad_clicks.id')
            ->where('ad_clicks.ads_id', $id)
            ->count();
        $count_views = DB::table('ad_views')
            ->select('ad_views.id')
            ->where('ad_views.ads_id', $id)
            ->count();
        return view('admin.ads.information', ['data' => $data, 'count_clicks' => $count_clicks, 'count_views' => $count_views]);
    }

    public function delete($id)
    {
        AdsManagement::where('id', $id)->delete();
        return redirect('ads/');
    }

    public function export()
    {
        $request = request()->all();
        $fileName = 'Ads-Report.csv';
        return Excel::download(new AdsExport($request['start_date'] ?? '0', $request['end_date'] ?? '0'), $fileName);
    }
}

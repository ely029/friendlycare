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
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        return view('admin.ads.index', ['data' => $details, 'start_date' => $start_date, 'end_date' => $end_date]);
    }

    public function viewInformation($id)
    {
        $data = DB::table('ads_management')
            ->leftJoin('ad_views', 'ads_management.id', 'ad_views.ads_id')
            ->leftJoin('ad_clicks', 'ads_management.id', 'ad_clicks.ads_id')
            ->select(
                'ads_management.title',
                DB::raw('count(ad_views.id) as count_views'),
                DB::raw('count(ad_clicks.id) as count_clicks'),
                'ads_management.id',
                'ads_management.ad_link',
                'ads_management.start_date',
                'ads_management.end_date',
                'ads_management.image_url')
            ->groupBy([
                'ads_management.id',
                'ads_management.ad_link',
                'ads_management.start_date',
                'ads_management.end_date',
                'ads_management.image_url',
            ])
            ->orderBy('ads_management.id')
            ->where('ads_management.id', $id)
            ->get();
        return view('admin.ads.information', ['data' => $data]);
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

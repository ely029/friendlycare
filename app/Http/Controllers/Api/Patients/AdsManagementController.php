<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\ClickAds;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsManagementController extends Controller
{
    public function display()
    {
        $dateNow = strtotime(date('Y-m-d'));
        return DB::table('ads_management')
            ->select('image_url', 'ad_link', 'id')
            ->where('start_date_string', '<=', $dateNow)
            ->where('end_date_string', '>=', $dateNow)
            ->get();
    }

    public function clickAds($id)
    {
        clickAds::create([
            'clicks' => 1,
            'ads_id' => $id,
        ]);
        $ads = DB::table('ads_management')->select('ad_link')->where('id', $id)->pluck('ad_link');
        return redirect($ads[0]);
    }
}

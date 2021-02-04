<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\AdsManagement;
use App\ClickAds;
use App\Http\Controllers\Controller;
use App\ViewAds;
use Illuminate\Support\Facades\DB;

class AdsManagementController extends Controller
{
    public function display()
    {
        $dateNow = strtotime(date('Y-m-d'));
        $ads = new AdsManagement();
        return $ads->getDisplayDetails($dateNow);
    }

    public function clickAds($id)
    {
        ClickAds::create([
            'clicks' => 1,
            'ads_id' => $id,
        ]);

        $ads1 = DB::table('ads_management')->select('ad_link')->where('id', $id)->pluck('ad_link');
        return redirect($ads1[0]);
    }

    public function viewAds($id)
    {
        ViewAds::create([
            'views' => 1,
            'ads_id' => $id,
        ]);

        return 0;
    }
}

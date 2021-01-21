<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsManagementController extends Controller
{
    public function display()
    {
        return DB::table('ads_management')
            ->select('image_url', 'ad_link', 'id')
            ->get();
    }
}

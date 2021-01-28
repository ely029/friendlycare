<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdsManagement extends Model
{
    protected $table = 'ads_management';

    protected $fillable = [
        'company_name',
        'title',
        'ad_link',
        'image_url',
        'start_date',
        'end_date',
        'clicks',
        'view',
        'end_date_string',
        'start_date_string',
    ];

    public function getAdsDetails()
    {
        return DB::table('ads_management')
            ->leftJoin('ad_views', 'ad_views.ads_id', 'ads_management.id')
            ->leftJoin('ad_clicks', 'ad_clicks.ads_id', 'ads_management.id')
            ->select('ads_management.start_date', 'ads_management.ad_link', 'ads_management.company_name', 'ads_management.title', 'ads_management.id',
            DB::raw('COUNT(DISTINCT ad_clicks.id) as clicks'),
            DB::raw('COUNT(DISTINCT ad_views.id) as views'))
            ->groupBy([
                'ads_management.ad_link',
                'ads_management.company_name',
                'ads_management.title',
                'ads_management.id',
            ])->get();
    }

    public function filter($request)
    {
        $dateFrom = Carbon::parse($request['start_date'])->format('Y-m-d');
        $dateTo = Carbon::parse($request['end_date'])->format('Y-m-d');
        return DB::table('ads_management')
            ->leftJoin('ad_views', 'ad_views.ads_id', 'ads_management.id')
            ->leftJoin('ad_clicks', 'ad_clicks.ads_id', 'ads_management.id')
            ->select(
                'ads_management.id',
                'ads_management.start_date',
                'ads_management.company_name',
                'ads_management.title',
                'ads_management.ad_link',
                DB::raw('COUNT(DISTINCT ad_views.id) as views'),
                DB::raw('COUNT(DISTINCT ad_clicks.id) as clicks'))
            ->groupBy(['ads_management.start_date', 'ads_management.id', 'ads_management.company_name', 'ads_management.title', 'ads_management.ad_link'])
            ->orderBy('ads_management.id')
            ->whereBetween('ads_management.created_at', [$dateFrom, $dateTo])
            ->get();
    }
}

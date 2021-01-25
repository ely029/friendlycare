<?php

declare(strict_types=1);

namespace App;

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
            ->select(
                'ads_management.id',
                'ads_management.start_date',
                'ads_management.company_name',
                'ads_management.title',
                'ads_management.ad_link',
                DB::raw('count(ad_views.id) as count_views'),
                DB::raw('count(ad_clicks.id) as count_clicks'))
            ->groupBy(['ads_management.start_date', 'ads_management.id', 'ads_management.company_name', 'ads_management.title', 'ads_management.ad_link'])
            ->orderBy('ads_management.id')
            ->get();
    }

    public function filter($request)
    {
        return DB::table('ads_management')
            ->leftJoin('ad_views', 'ad_views.ads_id', 'ads_management.id')
            ->leftJoin('ad_clicks', 'ad_clicks.ads_id', 'ads_management.id')
            ->select(
                'ads_management.id',
                'ads_management.start_date',
                'ads_management.company_name',
                'ads_management.title',
                'ads_management.ad_link',
                DB::raw('sum(ad_views.id) as count_views'),
                DB::raw('sum(ad_clicks.id) as count_clicks'))
            ->whereBetween('ads_management.created_at', [$request['start_date'], $request['end_date']])
            ->groupBy(['ads_management.start_date', 'ads_management.id', 'ads_management.company_name', 'ads_management.title', 'ads_management.ad_link'])
            ->orderBy('ads_management.id')
            ->get();
    }
}

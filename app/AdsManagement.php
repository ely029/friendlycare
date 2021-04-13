<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\AdsManagement
 *
 * @property int $id
 * @property string|null $company_name
 * @property string|null $title
 * @property string|null $ad_link
 * @property string|null $image_url
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $view
 * @property string|null $clicks
 * @property string|null $end_date_string
 * @property string|null $start_date_string
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereAdLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereEndDateString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereStartDateString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsManagement whereView($value)
 * @mixin \Eloquent
 */
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

    public function getDisplayDetails($dateNow)
    {
        return DB::table('ads_management')
            ->select('image_url', 'ad_link', 'id')
            ->where('start_date_string', '<=', $dateNow)
            ->where('end_date_string', '>=', $dateNow)
            ->get();
    }

    public function getViewInformation($id)
    {
        return DB::table('ads_management')
            ->leftJoin('ad_views', 'ad_views.ads_id', 'ads_management.id')
            ->leftJoin('ad_clicks', 'ad_clicks.ads_id', 'ads_management.id')
            ->select(
                'ads_management.start_date',
                'ads_management.ad_link',
                'ads_management.company_name',
                'ads_management.title',
                'ads_management.image_url',
                'ads_management.start_date',
                'ads_management.end_date',
                'ads_management.id',
        DB::raw('COUNT(DISTINCT ad_clicks.id) as count_clicks'),
        DB::raw('COUNT(DISTINCT ad_views.id) as count_views'))
            ->groupBy([
                'ads_management.image_url',
                'ads_management.ad_link',
                'ads_management.company_name',
                'ads_management.title',
                'ads_management.id',
                'ads_management.start_date',
                'ads_management.end_date',
            ])
            ->where('ads_management.id', $id)
            ->get();
    }
}

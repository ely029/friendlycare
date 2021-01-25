<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    private $dateFrom;
    private $dateTo;

    public function __construct(string $dateFrom, string $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function headings(): array
    {
        return ['URL', 'Company Name', 'Ad Title', 'Views', 'Clicks'];
    }

    public function collection()
    {
        return DB::table('ads_management')
            ->leftJoin('ad_clicks', 'ad_clicks.ads_id', 'ads_management.id')
            ->leftJoin('ad_views', 'ad_views.ads_id', 'ads_management.id')
            ->select('ad_link', 'company_name', 'title',
                DB::raw('count(ad_views.id) as views'),
                DB::raw('count(ad_clicks.id) as clicks'))
            ->orderBy('ads_management.id')
            ->groupBy(['ads_management.ad_link', 'ads_management.company_name', 'ads_management.title', 'ads_management.id'])
            ->whereBetween('ads_management.created_at', [$this->dateFrom, $this->dateTo])
            ->get();
    }
}

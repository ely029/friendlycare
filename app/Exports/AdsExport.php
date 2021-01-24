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
            ->select('ad_link', 'company_name', 'title',
                DB::raw('(select count(ad_views.id) as fff from ad_views left join ads_management 
                on ads_management.id = ad_views.ads_id where ad_views.created_at between ? and ?) as fff'),
                DB::raw('(select count(ad_clicks.id) as ggg from ad_clicks left join ads_management 
                on ads_management.id = ad_clicks.ads_id where ad_clicks.created_at between ? and ?) as ggg'))
            ->setBindings([$this->dateFrom, $this->dateTo, $this->dateFrom, $this->dateTo ])
            ->get();
    }
}

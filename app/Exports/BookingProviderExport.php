<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingProviderExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    private $dateFrom;
    private $dateTo;
    private $clinicId;

    public function __construct(string $dateFrom, string $dateTo, int $clinicId)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->clinicId = $clinicId;
    }

    public function headings(): array
    {
        return ['Name', 'Availed Service', 'Status', 'Name of Referrer', 'Date Booked', 'Clinic Name'];
    }

    public function collection()
    {
        return DB::table('booking')
            ->leftJoin('users', 'booking.patient_id', 'users.id')
            ->leftJoin('clinics', 'clinics.id', 'booking.clinic_id')
            ->join('status', 'status.id', 'booking.status')
            ->join('family_plan_type_subcategory as fpm', 'fpm.id', 'booking.service_id')
            ->select('users.name', 'fpm.name as availed_service', 'status.name as status', 'booking.referal', 'booking.time_slot as date_booked', 'clinics.clinic_name')
            ->where('booking.status', '<>', 6)
            ->where('booking.clinic_id', $this->clinicId)
            ->whereBetween('booking.time_slot', [$this->dateFrom, $this->dateTo])
            ->get();
    }
}

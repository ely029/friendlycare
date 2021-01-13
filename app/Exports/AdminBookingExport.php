<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminBookingExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    private $dateFrom;
    private $dateTo;
    private $clinicId;
    private $status;
    private $service;

    public function __construct(string $dateFrom, string $dateTo, string $clinicId, string $status, string $service)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->clinicId = $clinicId;
        $this->status = $status;
        $this->service = $service;
    }

    public function headings(): array
    {
        return ['Name', 'Availed Service', 'Status', 'Referal', 'Date Booked'];
    }

    public function collection()
    {
        return DB::table('booking')
            ->leftJoin('users', 'booking.patient_id', 'users.id')
            ->join('status', 'status.id', 'booking.status')
            ->join('family_plan_type_subcategory as fpm', 'fpm.id', 'booking.service_id')
            ->select('users.name', 'fpm.name as availed_service', 'status.name as status', 'booking.referal', 'booking.time_slot as date_booked')
            ->where('booking.status', $this->status)
            ->where('booking.clinic_id', $this->clinicId)
            ->where('booking.service_id', $this->service)
            ->whereBetween('booking.time_slot', [$this->dateFrom, $this->dateTo])
            ->get();
    }
}

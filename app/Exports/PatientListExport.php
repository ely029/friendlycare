<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientListExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    public function headings(): array
    {
        return ['Name', 'Age', 'Province', 'Municipality', 'FPM User Type'];
    }

    public function collection()
    {
        return DB::table('users')
            ->leftJoin('patients', 'patients.user_id', 'users.id')
            ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
            ->select('users.name', 'users.age', 'patients.province', 'patients.municipality', 'family_plan_type_subcategory.name as service_name')
            ->get();
    }
}

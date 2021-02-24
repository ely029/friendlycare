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

    private $dateFrom;
    private $dateTo;
    private $age;

    public function __construct(string $dateFrom, string $dateTo, string $age)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->age = $age;
    }

    public function headings(): array
    {
        return ['Name', 'Age', 'Province', 'Municipality', 'FPM User Type', 'Date Registered', 'Date Last Update', 'Family Plan Type User?', 'Family Planning Type', 'Family Method Used'];
    }

    public function collection()
    {
        if ($this->dateFrom === '0' && $this->dateTo === '0') {
            if ($this->age === '1') {
                return DB::table('users')
                    ->leftJoin('patients', 'patients.user_id', 'users.id')
                    ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
                    ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                    ->select('users.name', 'users.age', 'patients.province', 'patients.municipality', 'family_plan_type_subcategory.name as service_name', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), DB::raw('DATE_FORMAT(fpm_type_service.updated_at, "%m/%d/%Y") as date_last_update'), DB::raw('IF(fpm_type_service.service_id is null, "No", "Yes") as fpm_type_service'), DB::raw('(CASE WHEN patients.fpm_user_type = 1 THEN "New Acceptor" WHEN patients.fpm_user_type = 2 THEN "Changing Methods" WHEN patients.fpm_user_type = 3 THEN "Curent User" WHEN patients.fpm_user_type = 4 THEN "Restart" END)AS fpm_2'),
                    'family_plan_type_subcategory.name as fpm_1')
                    ->where('users.role_id', 3)
                    ->where('users.age', '<=', 19)
                    ->get();
            }
            return DB::table('users')
                ->leftJoin('patients', 'patients.user_id', 'users.id')
                ->distinct('users.name')
                ->join('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
                ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('users.name', 'users.age', 'patients.province', 'patients.municipality', 'family_plan_type_subcategory.name as service_name', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), DB::raw('DATE_FORMAT(fpm_type_service.updated_at, "%m/%d/%Y") as date_last_update'), DB::raw('IF(fpm_type_service.service_id is null, "No", "Yes") as fpm_type_service'), DB::raw('
                (
                    CASE 
                    WHEN patients.fpm_user_type = 1 THEN "New Acceptor"
                    WHEN patients.fpm_user_type = 2 THEN "Changing Methods"
                    WHEN patients.fpm_user_type = 3 THEN "Curent User"
                    WHEN patients.fpm_user_type = 4 THEN "Restart"
                    END
                )AS fpm_2'), 'family_plan_type_subcategory.name as fpm_1')
                ->where('users.role_id', 3)
                ->where('users.age', '>=', 20)
                ->get();
        }
        if ($this->age === '1') {
            return DB::table('users')
                ->leftJoin('patients', 'patients.user_id', 'users.id')
                ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
                ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
                ->select('users.name', 'users.age', 'patients.province', 'patients.municipality', 'family_plan_type_subcategory.name as service_name', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), DB::raw('DATE_FORMAT(fpm_type_service.updated_at, "%m/%d/%Y") as date_last_update'), DB::raw('IF(fpm_type_service.service_id is null, "No", "Yes") as fpm_type_service'), DB::raw('
                (
                    CASE 
                    WHEN patients.fpm_user_type = 1 THEN "New Acceptor"
                    WHEN patients.fpm_user_type = 2 THEN "Changing Methods"
                    WHEN patients.fpm_user_type = 3 THEN "Curent User"
                    WHEN patients.fpm_user_type = 4 THEN "Restart"
                    END
                )AS fpm_2'), 'family_plan_type_subcategory.name as fpm_1')
                ->where('users.role_id', 3)
                ->where('users.age', '<=', 19)
                ->whereBetween('users.created_at', [$this->dateFrom, $this->dateTo])
                ->get();
        }
        return DB::table('users')
            ->leftJoin('patients', 'patients.user_id', 'users.id')
            ->leftJoin('fpm_type_service', 'fpm_type_service.patient_id', 'users.id')
            ->leftJoin('family_plan_type_subcategory', 'family_plan_type_subcategory.id', 'fpm_type_service.service_id')
            ->select('users.name', 'users.age', 'patients.province', 'patients.municipality', 'family_plan_type_subcategory.name as service_name', DB::raw('DATE_FORMAT(users.created_at, "%m/%d/%Y") as registered_at'), DB::raw('DATE_FORMAT(fpm_type_service.updated_at, "%m/%d/%Y") as date_last_update'), DB::raw('IF(fpm_type_service.service_id is null, "No", "Yes") as fpm_type_service'), DB::raw('
            (
                CASE 
                WHEN patients.fpm_user_type = 1 THEN "New Acceptor"
                WHEN patients.fpm_user_type = 2 THEN "Changing Methods"
                WHEN patients.fpm_user_type = 3 THEN "Curent User"
                WHEN patients.fpm_user_type = 4 THEN "Restart"
                END
            )AS fpm_2'), 'family_plan_type_subcategory.name as fpm_1')
            ->where('users.role_id', 3)
            ->where('users.age', '>=', 20)
            ->whereBetween('users.created_at', [$this->dateFrom, $this->dateTo])
            ->get();
    }
}

<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'holiday';

    protected $fillable = [
        'clinic_id',
        'date',
        'holiday_title',
    ];

    public function getHolidayDetails($id)
    {
        $data = Holiday::where('clinic_id', $id);
        return response([$data]);
    }

    public function createHoliday($getClinicId, $obj)
    {
        Holiday::create([
            'clinic_id' => $getClinicId[0],
            'date' => $obj['date'][0],
            'holiday_title' => $obj['holiday_title'][0],
        ]);
    }
}

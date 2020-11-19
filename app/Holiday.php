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
    ];

    public function getHolidayDetails($id)
    {
        $data = Holiday::where('clinic_id', $id);
        return response([$data]);
    }
}

<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BookingTime
 *
 * @property int $id
 * @property int|null $patient_id
 * @property string|null $time_slot
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $booking_id
 * @property int|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime whereTimeSlot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingTime whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BookingTime extends Model
{
    protected $table = 'booking_time';
    protected $fillable = [
        'patient_id',
        'time_slot',
        'booking_id',
        'status',
    ];
}

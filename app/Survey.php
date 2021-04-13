<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Survey
 *
 * @property int $id
 * @property string|null $date_from_datestring
 * @property string|null $date_to_datestring
 * @property string|null $time
 * @property string|null $title
 * @property string|null $link
 * @property string|null $date_from
 * @property string|null $date_to
 * @property string|null $message
 * @property int|null $is_open
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $survey_display
 * @method static \Illuminate\Database\Eloquent\Builder|Survey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey query()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDateFromDatestring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDateToDatestring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereIsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Survey extends Model
{
    protected $table = 'survey';

    protected $fillable = [
        'date_from_datestring',
        'date_to_datestring',
        'time',
        'title',
        'message',
        'link',
        'date_from',
        'date_to',
        'is_open',
    ];
}

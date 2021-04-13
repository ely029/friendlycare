<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BasicPages
 *
 * @property int $id
 * @property string|null $content_name
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPages query()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPages whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPages whereContentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPages whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BasicPages extends Model
{
    protected $table = 'basic_pages';
    protected $fillable = [
        'content_name',
        'content',

    ];
}

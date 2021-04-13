<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BasicPageSection
 *
 * @property int $id
 * @property int|null $basic_page_id
 * @property string|null $title
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $section_title_1
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection query()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection whereBasicPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection whereSectionTitle1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicPageSection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BasicPageSection extends Model
{
    protected $table = 'basic_page_section';

    protected $fillable = [
        'title',
        'content',
        'basic_page_id',
        'section_title_1',
    ];
}

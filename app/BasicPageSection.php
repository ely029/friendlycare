<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

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

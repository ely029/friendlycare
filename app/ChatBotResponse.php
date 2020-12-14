<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatBotResponse extends Model
{
    protected $table = 'chat_bot_response';
    protected $fillable = [
        'response_prompt',
        'fieldset_id',
        'response_id',
    ];
}

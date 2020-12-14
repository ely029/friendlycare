<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatBot extends Model
{
    protected $table = 'chat_bot';
    protected $fillable = [
        'field_set_title',
        'chatbot_input',
    ];
}

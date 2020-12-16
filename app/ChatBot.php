<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatBot extends Model
{
    protected $table = 'chat_bot';
    protected $fillable = [
        'field_set_title',
        'chatbot_input',
    ];

    public function getIndexDetails()
    {
        return DB::table('chat_bot')
            ->select('field_set_title', 'chatbot_input')
            ->get();
    }

    public function getFieldSet()
    {
        return DB::table('chat_bot')
            ->select('field_set_title', 'id')
            ->get();
    }
}

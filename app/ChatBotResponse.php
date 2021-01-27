<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatBotResponse extends Model
{
    protected $table = 'chat_bot_response';
    protected $fillable = [
        'response_prompt',
        'fieldset_id',
        'response_id',
    ];

    public function getResponse($id)
    {
        return DB::table('chat_bot_response')
            ->leftJoin('chat_bot', 'chat_bot.id', 'chat_bot_response.response_id')
            ->select('chat_bot_response.id', 'chat_bot_response.fieldset_id', 'chat_bot_response.response_id', 'chat_bot.field_set_title', 'response_prompt')->where('fieldset_id', $id)->get();
    }
}

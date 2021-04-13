<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\ChatBotResponse
 *
 * @property int $id
 * @property string|null $response_prompt
 * @property int|null $fieldset_id
 * @property int|null $response_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse whereFieldsetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse whereResponsePrompt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBotResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\ChatBot
 *
 * @property int $id
 * @property string|null $field_set_title
 * @property string|null $chatbot_input
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBot query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBot whereChatbotInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBot whereFieldSetTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatBot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
            ->select('field_set_title', 'chatbot_input', 'id')
            ->get();
    }

    public function getFieldSet()
    {
        return DB::table('chat_bot')
            ->select('field_set_title', 'id')
            ->get();
    }
}

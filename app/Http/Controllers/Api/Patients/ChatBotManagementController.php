<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatBotManagementController extends Controller
{
    public function index($id)
    {
        $details = DB::table('chat_bot')
            ->select('chat_bot.chatbot_input')
            ->where('chat_bot.id', $id)
            ->get();

        return response([
            'name' => 'chatBotIndexMessage',
            'details' => $details,
        ]);
    }

    public function choices($id)
    {
        $details = DB::table('chat_bot_response')
            ->select('response_prompt', 'response_id')
            ->where('fieldset_id', $id)
            ->get();

        return response([
            'name' => 'chatBotChoices',
            'details' => $details,
        ]);
    }

    public function responses($id)
    {
        $details = DB::table('chat_bot')
            ->select('chatbot_input')
            ->where('id', $id)
            ->get();

        return response([
            'name' => 'chatBotResponse',
            'details' => $details,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ChatBot;
use App\ChatBotResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    public function index()
    {
        $chatbot = new ChatBot();
        $details = $chatbot->getIndexDetails();
        return view('admin.chatbot.index', ['details' => $details]);
    }

    public function create()
    {
        $chatbot = new ChatBot();
        $details = $chatbot->getFieldSet();
        return view('admin.chatbot.create', ['details' => $details]);
    }

    public function post()
    {
        $request = request()->all();
        ChatBot::create([
            'field_set_title' => $request['field_set_title'],
            'chatbot_input' => $request['chatbot_input'],
        ]);
        $id = DB::table('chat_bot')->select('id')->orderBy('id', 'desc')->pluck('id');
        $count = count($request['response_id']);
        for ($eee = 0; $eee <= $count; $eee++) {
            if (isset($request['response_id'][$eee])) {
                ChatBotResponse::create([
                    'response_prompt' => $request['response_prompt'][$eee],
                    'fieldset_id' => $id[0],
                    'response_id' => $request['response_id'][$eee],
                ]);
            }
        }
        return redirect('chatbot/list');
    }

    public function edit($id)
    {
        $chatbot = new ChatBot();
        $details = $chatbot->getFieldSet();
        $fieldset = ChatBot::where('id', $id)->get();
        $response = ChatBotResponse::where('fieldset_id', $id)->get();
        return view('admin.chatbot.edit', ['response' => $response, 'fieldset' => $fieldset, 'details' => $details]);
    }
}

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
            if (isset($request['response_prompt'][$eee])) {
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
        $chatBotResponse = new ChatBotResponse();
        $details = $chatbot->getFieldSet();
        $fieldset = ChatBot::where('id', $id)->get();
        $response = $chatBotResponse->getResponse($id);
        return view('admin.chatbot.edit', ['response' => $response, 'fieldset' => $fieldset, 'details' => $details]);
    }

    public function update()
    {
        $request = request()->all();
        ChatBot::where('id', $request['fieldset_id'])->update([
            'field_set_title' => $request['field_set_title'],
            'chatbot_input' => $request['chatbot_input'],
        ]);
        $elm1 = count($request['response_id']);
        for ($eee = 0; $eee <= $elm1;$eee++) {
            if (isset($request['response_id'][$eee])) {
                $this->check($request);
            }
        }
        return redirect('chatbot/list');
    }
    public function delete($id)
    {
        $getId = DB::table('chat_bot_response')->select('fieldset_id')->orderBy('fieldset_id', 'desc')->pluck('fieldset_id');
        $eee = [];
        $eee[] = $getId[0];
        ChatBotResponse::where('id', $id)->delete();
        foreach ($eee as $eey) {
            return redirect('chatbot/edit/'.$eey);
        }
    }

    public function deleteFieldSet($id)
    {
        ChatBot::where('id', $id)->delete();
        return redirect('/chatbot/list');
    }
    public function deleteResponse($fieldset, $id)
    {
        ChatBotResponse::where('id', $id)->delete();
        return redirect('chatbot/edit/'.$fieldset);
    }

    private function check($request)
    {
        $elm = count($request['response_id']);
        $this->check1($request, $elm);
    }

    private function check1($request, $elm)
    {
        for ($eee = 0; $eee <= $elm;  $eee++) {
            if (isset($request['responded_id'][$eee])) {
                $checked = DB::table('chat_bot_response')->select('id')->where('id', $request['responded_id'][$eee])->count();
                $this->check2($request, $checked, $eee);
            }
        }
    }

    private function check2($request, $checked, $eee)
    {
        if ($checked <= 0) {
            $response = [];
            $response[] = [
                'response_id' => $request['response_id'][$eee],
                'response_prompt' => $request['response_prompt'][$eee],
            ];
            $this->insertResponse($request, $response);
        } else {
            $this->updateResponse($request, $eee);
        }
    }

    private function updateResponse($request, $eee)
    {
        if (isset($request['response_prompt'][$eee])) {
            ChatBotResponse::where('id', $request['responded_id'][$eee])->update([
                'response_prompt' => $request['response_prompt'][$eee],
                'response_id' => $request['response_id'][$eee],
                'fieldset_id' => $request['fieldset_id'],
            ]);
        }
    }

    private function insertResponse($request, $response)
    {
        foreach ($response as $ely) {
            $getData = DB::table('chat_bot_response')->select('id')->where('response_prompt', $ely['response_prompt'])->count();
            if ($ely['response_prompt'] !== null && $ely['response_id'] !== null && $getData <= 0) {
                ChatBotResponse::create([
                    'response_prompt' => $ely['response_prompt'],
                    'response_id' => $ely['response_id'],
                    'fieldset_id' => $request['fieldset_id'],
                ]);
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ChatBot;
use App\Http\Controllers\Controller;

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
}

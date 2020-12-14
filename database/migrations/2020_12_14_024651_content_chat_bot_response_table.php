<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\ChatBot;
use App\ChatBotResponse;

class ContentChatBotResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ChatBot::create([
            'field_set_title' => 'Opening',
            'chatbot_input' => 'Good Day. How can I help you today',
        ]);

        ChatBot::create([
            'field_set_title' => 'BTL',
            'chatbot_input' => 'Sample Input About BTL',
        ]);

        ChatBot::create([
            'field_set_title' => 'What is FPM?',
            'chatbot_input' => 'FPM is a family planning method',
        ]);

        ChatBotResponse::create([
            'response_prompt' => 'What is FPM',
            'fieldset_id' => 1,
            'response_id' => 3,
        ]);

        ChatBotResponse::create([
            'response_prompt' => 'BTL',
            'fieldset_id' => 1,
            'response_id' => 2.
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

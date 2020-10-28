<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalHistoryAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_history_answer', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->integer('value_id')->nullable();
            $table->string('answer',100)->nullable();
            $table->string('string_answer',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_history_answer');
    }
}

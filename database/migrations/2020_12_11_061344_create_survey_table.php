<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->id();
            $table->longText('date_from_datestring')->nullable();
            $table->longText('date_to_datestring')->nullable();
            $table->string('time', 30)->nullable();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('date_from',30)->nullable();
            $table->string('date_to', 30)->nullable();
            $table->longText('message')->nullable();
            $table->integer('is_open')->default(0)->nullable();
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
        Schema::dropIfExists('survey');
    }
}

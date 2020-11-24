<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_notification', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->nullable();
            $table->text('message')->nullable();
            $table->integer('type')->nullable();
            $table->integer('schedule')->nullable();
            $table->integer('is_approve')->nullable();
            $table->text('date_string')->nullable();
            $table->text('date_time', 50)->nullable();
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
        Schema::dropIfExists('events_notification');
    }
}

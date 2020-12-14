<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->string('type', 50)->nullable();
            $table->integer('clinic_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('booking_id')->nullable();
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
        Schema::dropIfExists('provider_notifications');
    }
}

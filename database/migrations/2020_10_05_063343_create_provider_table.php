<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(0);
            $table->string('clinic_name')->nullable();
            $table->string('contact_number',15)->nullable();
            $table->string('location',100)->nullable();
            $table->boolean('is_close')->default(0);
            $table->boolean('is_approve')->default(0);
            $table->longText('close_message')->nullable();
            $table->longText('description')->nullable();
            $table->longText('profile_photo')->nullable();
            $table->string('profession',50)->nullable();
            $table->string('training',50)->nullable();
            $table->string('type',20)->nullable();
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
        Schema::dropIfExists('provider');
    }
}

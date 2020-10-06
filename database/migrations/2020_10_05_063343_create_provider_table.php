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
        Schema::create('clinic', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('clinic_name')->nullable();
            $table->string('contact_number',15)->nullable();
            $table->string('location',100)->nullable();
            $table->boolean('is_close')->default(0);
            $table->longText('close_message')->nullable();
            $table->longText('description')->nullable();
            $table->longText('profile_photo')->nullable();
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

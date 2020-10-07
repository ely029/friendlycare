<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->longText('day')->nullable();
            $table->longText('from')->nullable();
            $table->longText('to')->nullable();
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
        Schema::dropIfExists('clinic_hours');
    }
}

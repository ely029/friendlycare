<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spouses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('spouse_first_name',50)->nullable();
            $table->string('spouse_last_name',50)->nullable();
            $table->string('spouse_middle_initial',2)->nullable();
            $table->string('spouse_occupation',50)->nullable();
            $table->date('spouse_birth_date')->nullable();
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
        Schema::dropIfExists('patient');
    }
}

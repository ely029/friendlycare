<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('civil_status',10)->nullable();
            $table->string('religion',30)->nullable();
            $table->string('occupation',50)->nullable();
            $table->decimal('monthly_income')->nullable();
            $table->unsignedBigInteger('no_of_living_children')->nullable();
            $table->unsignedBigInteger('family_plan_type_id')->nullable();
            $table->string('barangay',50)->nullable();
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

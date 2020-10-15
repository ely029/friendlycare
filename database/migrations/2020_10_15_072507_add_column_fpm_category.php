<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFpmCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('family_plan_type_subcategory', function (Blueprint $table) {
            $table->string('short_name',50)->nullable();
            $table->string('percent_effective',10)->nullable();
            $table->string('typical_validity',100)->nullable();
            $table->text('description_english')->nullable();
            $table->text('description_filipino')->nullable();
            $table->text('how_it_works_english')->nullable();
            $table->text('how_it_works_filipino')->nullable();
            $table->text('side_effect_english')->nullable();
            $table->text('side_effect_filipino')->nullable();
            $table->text('additional_note_english')->nullable();
            $table->text('additional_note_filipino')->nullable();
        });
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

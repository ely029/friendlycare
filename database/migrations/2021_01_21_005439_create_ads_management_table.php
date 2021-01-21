<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_management', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 50)->nullable();
            $table->string('title', 50)->nullable();
            $table->string('ad_link')->nullable();
            $table->string('image_url')->nullable();
            $table->string('start_date',20)->nullable();
            $table->string('end_date', 20)->nullable();
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
        Schema::dropIfExists('ads_management');
    }
}

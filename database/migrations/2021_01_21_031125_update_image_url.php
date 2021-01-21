<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateImageUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('update ads_management set image_url = "i.picsum.photos/id/508/200/300.jpg?hmac=h7es7XtWndmLEtkzgE3VR1IHXLsLzKplxL_77_YNTGo", ad_link="https://facebook.com"');
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

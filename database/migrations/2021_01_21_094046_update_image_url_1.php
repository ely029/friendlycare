<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateImageUrl1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('update ads_management set image_url = "https://s3.envato.com/files/106367043/320%20x%20100%20copy.jpg", ad_link="https://facebook.com" where id = 1');
        DB::statement('update ads_management set image_url = "https://s3.envato.com/files/106367043/320%20x%20100%20copy.jpg", ad_link="https://facebook.com" where id = 2');
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

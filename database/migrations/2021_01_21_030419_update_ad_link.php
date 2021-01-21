<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('update ads_management set ad_link = "https://i.picsum.photos/id/363/200/300.jpg?hmac=LvonEMeE2QnwxULuBZW5xHtdjkz844GnAPpEhDwGvMY"');
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

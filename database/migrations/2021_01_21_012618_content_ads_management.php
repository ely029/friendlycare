<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\AdsManagement;

class ContentAdsManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        AdsManagement::create([
            'company_name' => 'ABC Inc',
            'ads_link' => 'https://facebook.com',
            'title' => 'Sample Title 1',
            'start_date' => '2021-01-22',
            'end_date' => '2021-01-29',
            'image_url' => 'https://www.virtwayevents.com/avatar-based-events/',
        ]);

        AdsManagement::create([
            'company_name' => 'XYZ Inc',
            'ads_link' => 'https://facebook.com',
            'title' => 'Sample Title 2',
            'start_date' => '2021-01-23',
            'end_date' => '2021-01-30',
            'image_url' => 'https://www.virtwayevents.com/avatar-based-events/',
        ]);
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicPagesContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('basic_pages')->insert([
            [
                'content_name' => 'About Us',
                'content' => 'content'
            ],
        ]);

        DB::table('basic_pages')->insert([
            [
                'content_name' => 'Terms and conditions',
                'content' => 'content'
            ],
        ]);

        DB::table('basic_pages')->insert([
            [
                'content_name' => 'Consent Form',
                'content' => 'content'
            ],
        ]);

        DB::table('basic_pages')->insert([
            [
                'content_name' => 'FAQs',
                'content' => 'content'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_pages');
    }
}

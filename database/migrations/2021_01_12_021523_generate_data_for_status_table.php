<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GenerateDataForStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('status')->insert([
            [
                'name' => 'Confirmed'
            ],
        ]);
        DB::table('status')->insert([
            [
                'name' => 'Reschedule'
            ],
        ]);
        DB::table('status')->insert([
            [
                'name' => 'Cancelled'
            ],
        ]);
        DB::table('status')->insert([
            [
                'name' => 'Complete'
            ],
        ]);

        DB::table('status')->insert([
            [
                'name' => 'No Show'
            ],
        ]);

        DB::table('status')->insert([
            [
                'name' => 'Pending'
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
        //
    }
}

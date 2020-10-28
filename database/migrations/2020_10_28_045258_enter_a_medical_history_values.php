<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnterAMedicalHistoryValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('medical_history_values')->insert([
            [
                'name' => 'tuberculosis',
            ],
        ]);

        DB::table('medical_history_values')->insert([
            [
                'name' => 'liver disease',
            ],
        ]);

        DB::table('medical_history_values')->insert([
            [
                'name' => 'heart disease',
            ],
        ]);

        DB::table('medical_history_values')->insert([
            [
                'name' => 'breast cancer',
            ],
        ]);

        DB::table('medical_history_values')->insert([
            [
                'name' => 'hypertension',
            ],
        ]);

        DB::table('medical_history_values')->insert([
            [
                'name' => 'diabetes',
            ],
        ]);

        DB::table('medical_history_values')->insert([
            [
                'name' => 'epilepsy',
            ],
        ]);

        DB::table('medical_history_values')->insert([
            [
                'name' => 'others',
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

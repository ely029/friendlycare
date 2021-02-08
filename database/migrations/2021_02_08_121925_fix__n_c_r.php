<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixNCR extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DELETE FROM refprovince where regCode = 13");
        DB::statement("DELETE FROM refcitymun where regDesc = 13 and id between 1350 and 1364");
        DB::statement("INSERT INTO refcitymun (citymunDesc, regdesc, citymuncode) values('CITY OF MANILA', 13, '137608')");
        DB::statement("insert into refprovince (provDesc, provCode, regcode) values('METRO MANILA',1686, 13)");
        DB::statement("update refcitymun set provcode = 1686 where regdesc = 13");
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

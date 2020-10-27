<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddASuperAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $email = "agtumala@friendlycare.com.ph";
        $password = "P@ssw0rd$$";

        app('command.migrate')->getOutput()->writeln('<info>Password:</info> See laravel.log');

        Log::warning("Security vulnerability! Update the account with the password, then delete this file!", [$email => $password]);

        $now = Carbon::now();
        DB::table('users')->insert([
            [
                'name' => 'Alex Tumala',
                'email' => $email,
                'password' => bcrypt($password),
                'role_id' => \App\Role::first()->id,
                'created_at' => $now,
                'updated_at' => $now,
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

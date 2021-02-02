<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;
use Carbon\Carbon;

class MigrateAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::where('email', 'kim@thinkbitsolutions.com')->delete();

        $email = "eladrica@friendlycare.com.ph";
        $password = "password1234";

        app('command.migrate')->getOutput()->writeln('<info>Password:</info> See laravel.log');

        Log::warning("Security vulnerability! Update the account with the password, then delete this file!", [$email => $password]);

        $now = Carbon::now();
        DB::table('users')->insert([
            [
                'name' => 'Eusebio Ladrica',
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

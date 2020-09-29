<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class CreateFirstUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $email = config('firewall.notifications.mail.to')[0];
        $password = App::isLocal() ? 'password' : Str::random(8);

        app('command.migrate')->getOutput()->writeln('<info>Password:</info> See laravel.log');

        Log::warning("Security vulnerability! Update the account with the password, then delete this file!", [$email => $password]);

        $now = Carbon::now();
        DB::table('users')->insert([
            [
                'name' => 'ThinkBIT Support',
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

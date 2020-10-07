<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('middle_initial',2)->nullable();
            $table->longText('password')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender',1)->nullable();
            $table->string('email',100)->unique();
            $table->string('age',2)->nullable();
            $table->string('city',50)->nullable();
            $table->string('municipality',50)->nullable();
            $table->string('province',50)->nullable();
            $table->string('contact_number',15)->nullable();
            $table->string('profession',100)->nullable();
            $table->string('training',100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // @TB
            $table->unsignedBigInteger('role_id');
            $table->string('photo_alt')->default('User Photo');
            $table->char('photo_extension', 4)->default('jpg');
            $table->string('fcm_notification_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');

        Storage::deleteDirectory(User::PATH_PREFIX);
    }
}

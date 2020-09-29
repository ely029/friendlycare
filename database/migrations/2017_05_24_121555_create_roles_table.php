<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_deletable')->default(true);
            $table->timestamps();
        });

        Schema::create('role_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('route')->index();
            $table->timestamps();
        });

        // Seed
        $role = \App\Role::forceCreate([
            'name' => 'Admin',
            'is_deletable' => false,
        ]);

        $role->accesses()->saveMany(\App\RoleRoute::getActionName()->map(function ($route) {
            return new \App\RoleAccess(['route' => $route]);
        }));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_accesses');
        Schema::dropIfExists('roles');
    }
}

<?php

use App\Http\Middleware\AuthenticateOnce;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// @TB: See AuthenticateOnce middleware
class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('driver', AuthenticateOnce::SUPPORTED_DRIVERS);
            $table->string('social_id');
            $table->text('token');

            $table->index(['driver', 'social_id']);

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('socials');

        Schema::enableForeignKeyConstraints();
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('vip')->nullable();
            $table->string('name')->nullable();
            $table->string('realname')->nullable();
            $table->text('biography')->nullable();
            $table->string('location')->nullable();
            $table->date('birthday')->nullable();
            $table->double('money', 64, 2)->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_steam')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('username', 32)->unique();
            $table->string('ip', 40)->nullable();
            $table->bigInteger('lastlogin')->nullable();
            $table->double('x')->nullable();
            $table->double('y')->nullable();
            $table->double('z')->nullable();
            $table->string('world')->nullable();
            $table->boolean('isAdmin')->default(0);
            $table->boolean('isLogged')->default(0);
            $table->rememberToken();
            $table->timestamps();
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
    }
}

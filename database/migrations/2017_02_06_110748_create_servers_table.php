<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('image_id')->nullable();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('ip', 40);
            $table->string('host', 40);
            $table->integer('port');
            $table->boolean('status')->default(0);
            $table->integer('online')->default(0);
            $table->integer('slot')->default(0);
            $table->text('rcon');
            $table->timestamps();
        });

        Schema::table('servers', function (Blueprint $table) {
            $table->foreign('image_id')
                ->references('id')->on('images')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}

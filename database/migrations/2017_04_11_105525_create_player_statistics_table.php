<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('servername')->nullable()->default('default');
            $table->bigInteger('player_kills')->nullable()->default(0);
            $table->bigInteger('mob_kills')->nullable()->default(0);
            $table->bigInteger('deaths')->nullable()->default(0);
            $table->boolean('is_online')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_statistics');
    }
}

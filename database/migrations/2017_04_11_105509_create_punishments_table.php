<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePunishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Punishments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->text('uuid')->nullable();
            $table->text('reason')->nullable();
            $table->text('operator')->nullable();
            $table->text('punishmentType')->nullable();
            $table->mediumText('start')->nullable();
            $table->mediumText('end')->nullable();
            $table->text('calculation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Punishments');
    }
}

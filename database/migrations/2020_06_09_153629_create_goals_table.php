<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('game')->constrained();
            $table->foreignId('team')->constrained();
            $table->bigInteger('scorer')->unsigned();
            $table->bigInteger('assist_1')->unsigned()->nullable();
            $table->bigInteger('assist_2')->unsigned()->nullable();
            $table->bigInteger('goalie')->unsigned()->nullable();
            $table->integer('second');
            $table->foreign('scorer')->references('id')->on('players')->nullable();
            $table->foreign('assist_1')->references('id')->on('players')->nullable();
            $table->foreign('assist_2')->references('id')->on('players')->nullable();
            $table->foreign('goalie')->references('id')->on('players')->nullable();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('goals');
        Schema::enableForeignKeyConstraints();
    }
}

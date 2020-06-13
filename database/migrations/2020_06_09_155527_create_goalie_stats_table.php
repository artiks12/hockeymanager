<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalieStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goalie_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('player')->constrained();
            $table->foreignId('game')->constrained();
            $table->integer('games');
            $table->integer('SOG');
            $table->integer('GA');
            $table->integer('seconds');
            $table->integer('shutouts');
            $table->integer('Goals');
            $table->integer('Assists');
            $table->integer('PIM');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goalie_stats');
    }
}

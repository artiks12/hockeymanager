<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('season')->constrained();
            $table->foreignId('team')->constrained();
            $table->integer('victories');
            $table->integer('defeats');
            $table->integer('overtimes');
            $table->integer('points');
            $table->integer('scoredGoals');
            $table->integer('goalsAgainst');
            $table->integer('goalDifference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_stats');
    }
}

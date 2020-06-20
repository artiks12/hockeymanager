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
            $table->integer('victories')->default(0);
            $table->integer('defeats')->default(0);
            $table->integer('overtimes')->default(0);
            $table->integer('points')->default(0);
            $table->integer('scoredGoals')->default(0);
            $table->integer('goalsAgainst')->default(0);
            $table->integer('goalDifference')->default(0);
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

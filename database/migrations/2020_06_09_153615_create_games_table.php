<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('season')->constrained();
            $table->timestamp('date');
            $table->bigInteger('HostTeam')->unsigned();
            $table->integer('HomeScore')->nullable();
            $table->integer('VisitorScore')->nullable();
            $table->bigInteger('VisitingTeam')->unsigned();
            $table->foreign('HostTeam')->references('id')->on('teams');
            $table->foreign('VisitingTeam')->references('id')->on('teams');
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
        Schema::dropIfExists('games');
        Schema::enableForeignKeyConstraints();
    }
}

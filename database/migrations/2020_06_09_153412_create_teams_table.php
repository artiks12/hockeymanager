<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('teamName');
            $table->bigInteger('league')->unsigned()->nullable();
            $table->bigInteger('season')->unsigned()->nullable();
            $table->bigInteger('manager')->unsigned();
            $table->bigInteger('statistician')->unsigned()->nullable();
            $table->foreign('league')->references('id')->on('leagues');
            $table->foreign('season')->references('id')->on('seasons');
            $table->foreign('manager')->references('id')->on('users');
            $table->foreign('statistician')->references('id')->on('users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}

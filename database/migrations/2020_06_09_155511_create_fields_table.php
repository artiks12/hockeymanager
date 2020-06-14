<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('player')->constrained();
            $table->foreignId('season')->constrained();
            $table->foreignId('team')->constrained();
            $table->foreignId('game')->constrained();
            $table->integer('games');
            $table->integer('goals');
            $table->integer('assists');
            $table->integer('plus_minus');
            $table->integer('PIM');
            $table->integer('faceoffs');
            $table->integer('faceoffsWon');
            $table->integer('shots');
            $table->integer('blockedShots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}

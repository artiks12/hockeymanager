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
            $table->integer('games')->default(0);
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('plus_minus')->default(0);
            $table->integer('PIM')->default(0);
            $table->integer('faceoffs')->default(0);
            $table->integer('faceoffsWon')->default(0);
            $table->integer('shots')->default(0);
            $table->integer('blockedShots')->default(0);
            $table->integer('is_set')->default(0);
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

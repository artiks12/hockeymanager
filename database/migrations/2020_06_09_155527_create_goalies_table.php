<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoaliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goalies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('player')->constrained();
            $table->foreignId('season')->constrained();
            $table->foreignId('team')->constrained();
            $table->foreignId('game')->constrained();
            $table->integer('games')->default(0);
            $table->integer('wins')->default(0);
            $table->integer('loses')->default(0);
            $table->integer('SOG')->default(0);
            $table->integer('GA')->default(0);
            $table->integer('seconds')->default(0);
            $table->integer('shutouts')->default(0);
            $table->integer('Goals')->default(0);
            $table->integer('Assists')->default(0);
            $table->integer('PIM')->default(0);
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
        Schema::dropIfExists('goalies');
    }
}

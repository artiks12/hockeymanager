<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('player')->constrained();
            $table->foreignId('game')->constrained();
            $table->integer('games');
            $table->integer('goals');
            $table->integer('assists');
            $table->integer('plus/minus');
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
        Schema::dropIfExists('field_stats');
    }
}

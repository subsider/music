<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('score_type_id');
            $table->morphs('owner');
            $table->morphs('model');
            $table->unsignedInteger('points');
            $table->unsignedInteger('count')->nullable();
            $table->timestamps();

            $table->foreign('score_type_id')
                ->references('id')
                ->on('score_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}

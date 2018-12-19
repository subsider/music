<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadioTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radio_tracks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('radio_id');
            $table->unsignedBigInteger('track_id');
            $table->unsignedInteger('rank')->nullable();
            $table->timestamps();

            $table->foreign('radio_id')
                ->references('id')
                ->on('radios')
                ->onDelete('cascade');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->onDelete('cascade');

            $table->unique(['radio_id', 'track_id', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radio_tracks');
    }
}

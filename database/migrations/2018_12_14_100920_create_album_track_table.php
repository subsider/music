<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_track', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('album_id');
            $table->unsignedBigInteger('track_id');
            $table->string('position')->index()->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->unsignedInteger('disk_number')->nullable();
            $table->string('isrc')->nullable();
            $table->unsignedInteger('bpm')->nullable();
            $table->integer('gain')->nullable();
            $table->timestamps();

            $table->foreign('album_id')
                ->references('id')
                ->on('albums')
                ->onDelete('cascade');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->onDelete('cascade');

            $table->unique(['album_id', 'track_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_track');
    }
}

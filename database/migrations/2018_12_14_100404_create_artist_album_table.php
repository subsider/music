<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_album', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id');
            $table->unsignedBigInteger('album_id');
            $table->string('role')->nullable();
            $table->string('joinphrase')->nullable();

            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->onDelete('cascade');

            $table->foreign('album_id')
                ->references('id')
                ->on('albums')
                ->onDelete('cascade');

            $table->unique(['artist_id', 'album_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_album');
    }
}

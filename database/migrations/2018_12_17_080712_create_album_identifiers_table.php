<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_identifiers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('album_id');
            $table->string('type');
            $table->string('value');
            $table->timestamps();

            $table->foreign('album_id')
                ->references('id')
                ->on('albums')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_identifiers');
    }
}

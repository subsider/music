<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('album_type_id')->nullable();
            $table->uuid('mbid')->nullable();
            $table->string('name');
            $table->unsignedInteger('duration')->nullable();
            $table->boolean('explicit_lyrics')->nullable();
            $table->unsignedInteger('track_count')->nullable();
            $table->unsignedBigInteger('upc')->nullable();
            $table->year('year')->nullable();
            $table->dateTime('release_date')->nullable();
            $table->string('discogs_main_release_type')->nullable();
            $table->unsignedInteger('discogs_main_release_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('album_type_id')
                ->references('id')
                ->on('album_types')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}

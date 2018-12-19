<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_format', function (Blueprint $table) {
            $table->unsignedBigInteger('album_id');
            $table->unsignedInteger('format_id');
            $table->unsignedInteger('weight')->nullable();

            $table->foreign('album_id')
                ->references('id')
                ->on('albums')
                ->onDelete('cascade');

            $table->foreign('format_id')
                ->references('id')
                ->on('formats')
                ->onDelete('cascade');

            $table->unique(['album_id', 'format_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_format');
    }
}

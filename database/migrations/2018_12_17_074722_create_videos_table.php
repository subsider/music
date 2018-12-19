<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('model');
            $table->unsignedInteger('streamer_type_id')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->boolean('embed')->nullable();
            $table->string('src');
            $table->timestamps();

            $table->foreign('streamer_type_id')
                ->references('id')
                ->on('streamer_types')
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
        Schema::dropIfExists('videos');
    }
}

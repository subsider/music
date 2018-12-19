<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('mbid')->nullable();
            $table->string('name');
            $table->string('sort_name')->nullable();
            $table->unsignedInteger('album_count')->nullable();
            $table->string('facebook_page_url')->nullable();
            $table->unsignedInteger('upcoming_event_count')->nullable();
            $table->dateTime('on_tour_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artists');
    }
}

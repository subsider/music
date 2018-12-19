<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('event_id');
            $table->string('type', 10)->default('Tickets');
            $table->string('url')->nullable();
            $table->string('status', 10)->default('available');
            $table->timestamps();

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
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
        Schema::dropIfExists('event_offers');
    }
}

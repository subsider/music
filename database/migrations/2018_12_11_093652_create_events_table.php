<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('event_type_id')->nullable();
            $table->unsignedBigInteger('place_id');
            $table->text('description')->nullable();
            $table->dateTimeTz('celebration_date')->nullable();
            $table->dateTimeTz('on_sale_date')->nullable();
            $table->timestamps();

            $table->foreign('event_type_id')
                ->references('id')
                ->on('event_types')
                ->onDelete('SET NULL');

            $table->foreign('place_id')
                ->references('id')
                ->on('places')
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
        Schema::dropIfExists('events');
    }
}

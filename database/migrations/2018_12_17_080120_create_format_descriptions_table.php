<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('format_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('format_id');
            $table->string('description');
            $table->timestamps();

            $table->foreign('format_id')
                ->references('id')
                ->on('formats')
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
        Schema::dropIfExists('format_descriptions');
    }
}

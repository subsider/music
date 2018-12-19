<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('model');
            $table->unsignedBigInteger('related_id');
            $table->timestamps();

            $table->unique(['model_id', 'model_type', 'related_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related');
    }
}

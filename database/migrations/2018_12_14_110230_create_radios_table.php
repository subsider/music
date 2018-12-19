<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('radio_type_id');
            $table->string('internal_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('radio_type_id')
                ->references('id')
                ->on('radio_types')
                ->onDelete('cascade');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
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
        Schema::dropIfExists('radios');
    }
}

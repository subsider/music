<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('provider_id')->nullable();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('web_url')->unique()->nullable();
            $table->string('twitter')->unique()->nullable();
            $table->string('logo')->unique()->nullable();
            $table->unsignedInteger('aoty_id')->unique()->nullable();
            $table->string('aoty_url')->unique()->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('publications');
    }
}

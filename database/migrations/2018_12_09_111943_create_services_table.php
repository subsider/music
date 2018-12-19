<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('provider_id');
            $table->morphs('model');
            $table->string('internal_id')->nullable();
            $table->text('api_url')->nullable();
            $table->text('web_url')->nullable();
            $table->text('tracklist_url')->nullable();
            $table->text('preview_url')->nullable();
            $table->unsignedInteger('listeners')->nullable();
            $table->unsignedInteger('count')->nullable();
            $table->unsignedInteger('rank')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->unsignedTinyInteger('popularity')->nullable();
            $table->boolean('streamable')->nullable();
            $table->timestamp('crawled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('services');
    }
}

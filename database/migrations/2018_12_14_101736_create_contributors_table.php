<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);

        Schema::create('contributors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('artist_id');
            $table->morphs('model');
            $table->unsignedBigInteger('context_id')->nullable();
            $table->string('context_type')->nullable();
            $table->string('role');
            $table->timestamps();

            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->onDelete('cascade');

            $table->unique(
                ['artist_id', 'model_id', 'model_type', 'context_id', 'context_type', 'role'],
                'contributors_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributors');
    }
}

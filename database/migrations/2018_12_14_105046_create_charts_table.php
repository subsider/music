<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('chart_type_id');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->string('owner_type')->nullable();
            $table->string('internal_id')->nullable();
            $table->string('name');
            $table->boolean('public')->nullable();
            $table->uuid('checksum')->nullable();
            $table->text('tracklist_url')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('chart_type_id')
                ->references('id')
                ->on('chart_types')
                ->onDelete('cascade');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');

            $table->unique(
                ['provider_id', 'chart_type_id', 'owner_id', 'owner_type', 'internal_id'],
                'chart_unique'
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
        Schema::dropIfExists('charts');
    }
}

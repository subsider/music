<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chart_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedInteger('rank');
            $table->unsignedInteger('score')->nullable();
            $table->timestamps();

            $table->foreign('chart_id')
                ->references('id')
                ->on('charts')
                ->onDelete('cascade');

            $table->unique(['chart_id', 'item_id', 'rank', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chart_items');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('internal_id')->nullable();
            $table->morphs('model');
            $table->morphs('context');
            $table->text('body');
            $table->timestamp('published_at');
            $table->timestamps();

            $table->unique(
                ['internal_id', 'model_id', 'model_type', 'context_id', 'context_type'],
                'comments_unique'
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
        Schema::dropIfExists('comments');
    }
}

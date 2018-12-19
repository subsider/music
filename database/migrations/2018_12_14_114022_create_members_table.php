<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('artist_id');
            $table->boolean('active');
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('artists')
                ->onDelete('cascade');

            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->onDelete('cascade');

            $table->unique(['group_id', 'artist_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}

<?php

use App\Music\Genre;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class AddDeezerGenres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('deezer:genre:crawl');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Genre::truncate();
    }
}

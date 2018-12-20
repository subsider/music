<?php

use App\Models\Music\Genre;
use App\Models\Provider\Service;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Migrations\Migration;

class AddAotyGenres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('aoty:genre:crawl');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Service::truncate();
        Genre::truncate();
    }
}

<?php

use App\Models\Provider\Publication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class AddAotyPublications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('aoty:publication:crawl');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Publication::truncate();
    }
}

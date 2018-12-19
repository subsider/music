<?php

use App\Models\Type\ChartType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultChartTypes extends Migration
{
    /**
     * @var array
     */
    protected $types = [
        'artist',
        'album',
        'track',
        'playlist',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            ChartType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        ChartType::truncate();
    }
}

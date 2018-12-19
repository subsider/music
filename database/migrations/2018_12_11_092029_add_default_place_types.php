<?php

use App\Models\Type\PlaceType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultPlaceTypes extends Migration
{
    protected $types = [
        'Venue',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            PlaceType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        PlaceType::truncate();
    }
}

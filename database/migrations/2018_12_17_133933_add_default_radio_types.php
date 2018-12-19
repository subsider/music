<?php

use App\Models\Type\RadioType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultRadioTypes extends Migration
{
    /**
     * @var array
     */
    protected $types = [
        'artist',
        'album',
        'track',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            RadioType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RadioType::truncate();
    }
}

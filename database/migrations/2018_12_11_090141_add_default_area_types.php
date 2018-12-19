<?php

use App\Models\Type\AreaType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultAreaTypes extends Migration
{
    protected $types = [
        'City',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            AreaType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        AreaType::truncate();
    }
}

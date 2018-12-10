<?php

use App\Models\Type\ImageType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultImageTypes extends Migration
{
    protected $types = [
        'icon',
        'avatar',
        'thumb',
        'cover',
        'picture',
        'large',
        'header',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            ImageType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        ImageType::truncate();
    }
}

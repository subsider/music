<?php

use App\Models\Type\AlbumType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultAlbumTypes extends Migration
{
    /**
     * @var array
     */
    protected $types = [
        'album',
        'single',
        'compile',
        'ep',
        'bundle',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            AlbumType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        AlbumType::truncate();
    }
}

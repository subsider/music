<?php

use App\Models\Type\TagType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultTagTypes extends Migration
{
    /**
     * @var array
     */
    protected $types = [
        'tag',
        'genre',
        'style',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            TagType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        TagType::truncate();
    }
}

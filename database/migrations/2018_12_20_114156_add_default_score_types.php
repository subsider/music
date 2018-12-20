<?php

use App\Models\Type\ScoreType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultScoreTypes extends Migration
{
    /**
     * @var array
     */
    protected $types = ['critic', 'user'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            ScoreType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        ScoreType::truncate();
    }
}

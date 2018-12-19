<?php

use App\Models\Type\CompanyType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultLabelTypes extends Migration
{
    /**
     * @var array
     */
    protected $types = [
        'label',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->types as $name) {
            CompanyType::create(['name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        CompanyType::truncate();
    }
}

<?php

namespace App\Models\Geo;

use App\Models\BaseModel;

class Country extends BaseModel
{
    public function areas()
    {
        return $this->hasMany(Area::class, 'country_code');
    }
}

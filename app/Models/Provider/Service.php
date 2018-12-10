<?php

namespace App\Models\Provider;

use App\Models\BaseModel;

class Service extends BaseModel
{
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}

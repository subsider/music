<?php

namespace App\Models\Provider;

use App\Models\BaseModel;

class Service extends BaseModel
{
    protected $dates = ['crawled_at', 'deleted_at'];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}

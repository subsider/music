<?php

namespace App\Models\Music;

use App\Models\BaseModel;

class Related extends BaseModel
{
    protected $table = 'related';

    public function model()
    {
        return $this->morphTo();
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'related_id');
    }
}

<?php

namespace App\Models\Util;

use App\Models\BaseModel;

class Command extends BaseModel
{
    protected $dates = ['crawled_at', 'deleted_at'];
}

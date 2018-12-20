<?php

namespace App\Models\Music;

use App\Models\BaseModel;

class Streaming extends BaseModel
{
    public static $streamers = [
        'Youtube' => 1,
        'Amazon'  => 2,
        'iTunes'  => 3,
        'Music'   => 4,
        'Spotify' => 5,
    ];
}

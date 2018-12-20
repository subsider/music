<?php

use App\Models\Type\StreamerType;
use Illuminate\Database\Migrations\Migration;

class AddDefaultStreamerTypes extends Migration
{
    /**
     * @var array
     */
    protected $streamers = [
        'Youtube'     => 'https://www.youtube.com',
        'Amazon'      => 'http://www.amazon.com',
        'iTunes'      => 'https://itunes.apple.com',
        'Apple Music' => 'https://itunes.apple.com',
        'Spotify'     => 'http://open.spotify.com',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->streamers as $name => $url) {
            StreamerType::create([
                'name' => $name,
                'url'  => $url,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        StreamerType::truncate();
    }
}

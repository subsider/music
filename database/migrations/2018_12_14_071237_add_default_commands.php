<?php

use App\Models\Util\Command;
use Illuminate\Database\Migrations\Migration;

class AddDefaultCommands extends Migration
{
    protected $commands = [
        'bandsintown:artist:batch',
        'deezer:artist:batch',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->commands as $signature) {
            Command::create([
                'signature' => $signature,
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
        Command::truncate();
    }
}

<?php

namespace App\Console\Commands\Deezer\Album;

use App\Jobs\Deezer\Album\ProcessAlbumTracks;
use Illuminate\Console\Command;

class AlbumTracksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:album:tracks {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ProcessAlbumTracks::dispatch($this->argument('id'));
    }
}

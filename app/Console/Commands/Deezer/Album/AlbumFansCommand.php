<?php

namespace App\Console\Commands\Deezer\Album;

use App\Jobs\Deezer\Album\ProcessAlbumFans;
use Illuminate\Console\Command;

class AlbumFansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:album:fans {id}';

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
        ProcessAlbumFans::dispatch($this->argument('id'));
    }
}

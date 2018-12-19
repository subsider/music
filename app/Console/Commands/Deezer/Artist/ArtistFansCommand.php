<?php

namespace App\Console\Commands\Deezer\Artist;

use App\Jobs\Deezer\Artist\ProcessArtistFans;
use Illuminate\Console\Command;

class ArtistFansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:artist:fans {id}';

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
        ProcessArtistFans::dispatch($this->argument('id'));
    }
}

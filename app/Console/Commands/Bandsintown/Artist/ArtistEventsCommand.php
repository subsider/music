<?php

namespace App\Console\Commands\Bandsintown\Artist;

use App\Jobs\Bandsintown\Artist\ProcessArtistEvents;
use Illuminate\Console\Command;

class ArtistEventsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bandsintown:artist:events {artist}';

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
        ProcessArtistEvents::dispatch($this->argument('artist'));
    }
}

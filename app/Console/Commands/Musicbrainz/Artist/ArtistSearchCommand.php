<?php

namespace App\Console\Commands\Musicbrainz\Artist;

use App\Jobs\Musicbrainz\Artist\ProcessArtistSearch;
use Illuminate\Console\Command;

class ArtistSearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'musicbrainz:artist:search {artist}';

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
        ProcessArtistSearch::dispatch($this->argument('artist'));
    }
}
<?php

namespace App\Console\Commands\Bandsintown\Artist;

use App\Jobs\Bandsintown\Artist\ProcessArtistInfo;
use Illuminate\Console\Command;

class ArtistInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bandsintown:artist:info {artist}';

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

    public function handle()
    {
        ProcessArtistInfo::dispatch($this->argument('artist'));
    }
}

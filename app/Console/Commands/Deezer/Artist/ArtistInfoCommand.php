<?php

namespace App\Console\Commands\Deezer\Artist;

use App\Jobs\Deezer\Artist\ProcessArtistInfo;
use Illuminate\Console\Command;

class ArtistInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:artist:info {id}';

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
        ProcessArtistInfo::dispatch($this->argument('id'));
    }
}

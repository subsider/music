<?php

namespace App\Console\Commands\Deezer\Track;

use App\Jobs\Deezer\Track\ProcessTrackInfo;
use Illuminate\Console\Command;

class TrackInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:track:info {id}';

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
        ProcessTrackInfo::dispatch($this->argument('id'));
    }
}

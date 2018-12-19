<?php

namespace App\Console\Commands\Subsider\Album;

use App\Models\Music\Album;
use Illuminate\Console\Command;

class FixAlbumDateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'album:date:fix';

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
        foreach (Album::whereNotNull('release_date')->whereNull('year')->cursor() as $album) {
            $album->update([
                'year' => $album->release_date->year,
            ]);

            $this->info($album->name);
        }
    }
}

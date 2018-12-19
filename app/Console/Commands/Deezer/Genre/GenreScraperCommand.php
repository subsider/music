<?php

namespace App\Console\Commands\Deezer\Genre;

use App\Collections\DeezerGenres;
use App\Models\Music\Genre;
use Illuminate\Console\Command;

class GenreScraperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:genre:crawl';

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

    public function handle(DeezerGenres $genres)
    {
        foreach ($genres->get() as $name => $id) {
            $genre = Genre::updateOrCreate(['name' => $name]);
            $genre->services()->updateOrCreate([
                'provider_id' => config('clients.deezer.id'),
                'api_url'     => config('clients.deezer.api_url') . 'genre/' . $id,
                'internal_id' => $id,
            ]);
        }
    }
}

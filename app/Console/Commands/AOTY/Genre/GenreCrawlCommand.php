<?php

namespace App\Console\Commands\AOTY\Genre;

use App\Collections\AOTYGenres;
use App\Models\Music\Genre;
use Illuminate\Console\Command;

class GenreCrawlCommand extends Command
{
    /**
     * @var array
     */
    protected $genres = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoty:genre:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
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
        $aotyGenres = new AOTYGenres;

        foreach ($aotyGenres->get() as $name => $item) {
            $genre = Genre::updateOrCreate([
                'slug' => str_slug($name),
                'name' => $name,
            ]);

            $genre->services()->updateOrCreate([
                'provider_id' => config('clients.aoty.id'),
                'internal_id' => $item['internal_id'],
                'web_url'     => $item['url'],
            ]);
        }


//        $canonicalUrl = config('clients.aoty.web_url');
//        $crawler      = \Goutte::request('GET', $canonicalUrl . '/genre.php');
//        $crawler->filter('.rightBox')
//            ->eq(0)
//            ->filter('div > a')
//            ->each(function ($node) use ($canonicalUrl) {
//                $genreName  = $node->text();
//                $url        = $node->attr('href');
//                $internalId = explode('/', explode('-', $url)[0])[2];
//
//                $this->genres[$genreName] = [
//                    'slug'        => str_slug($genreName),
//                    'url'         => $canonicalUrl . $url,
//                    'internal_id' => intval($internalId),
//                ];

//                $genre = Genre::updateOrCreate([
//                    'slug' => str_slug($genreName),
//                    'name' => $genreName,
//                ]);
//
//                $genre->services()->updateOrCreate([
//                    'provider_id' => config('clients')
//                ]);


        // Urls like https://www.albumoftheyear.org/genre/234-abstract-hip-hop/2017/1
        // https://www.albumoftheyear.org/genre/19-soul/2018/1/
        // https://www.albumoftheyear.org/genre/19-soul/2018/american-songwriter/1/
//            });
//
//        dump($this->genres);
    }
}

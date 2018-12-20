<?php

namespace App\Console\Commands\AOTY\Genre;

use Illuminate\Console\Command;

class GenreCrawlCommand extends Command
{
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
        $canonicalUrl = 'https://www.albumoftheyear.org';
        $crawler      = \Goutte::request('GET', $canonicalUrl . '/genre.php');
        $crawler->filter('.rightBox')
            ->eq(0)
            ->filter('div > a')
            ->each(function ($node) use ($canonicalUrl) {
                $genreName  = $node->text();
                $url        = $node->attr('href');
                $internalId = explode('/',explode('-', $url)[0])[2];

                $array = [
                    'name'        => $genreName,
                    'url'         => $canonicalUrl . $url,
                    'internal_id' => intval($internalId),
                ];

                // Urls like https://www.albumoftheyear.org/genre/234-abstract-hip-hop/2017/1
                // https://www.albumoftheyear.org/genre/19-soul/2018/1/
                // https://www.albumoftheyear.org/genre/19-soul/2018/american-songwriter/1/

                dump($array);
            });
    }
}

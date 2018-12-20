<?php

namespace App\Console\Commands\AOTY\Publication;

use Illuminate\Console\Command;

class PublicationCrawlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoty:publication:crawl';

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
        $year         = now()->year;
        $canonicalUrl = 'https://www.albumoftheyear.org';
        $segment      = '/ratings/6-highest-rated/';

        for ($i = 1990; $i <= $year; $i++) {
            $this->warn($i);
            $url     = "{$canonicalUrl}{$segment}{$i}/1";
            $crawler = \Goutte::request('GET', $url);
            $this->warn($url);
            $crawler->filter('.rightContent .rightBox')
                ->eq(1)
                ->filter('.listItem > a')
                ->each(function ($node) use ($canonicalUrl, $i) {
                    $publicationName = $node->text();
                    $url             = explode('/', $node->attr('href'));
                    array_pop($url);
                    $chartUrl         = $canonicalUrl . implode('/', $url);
                    $parts            = explode('/', $node->attr('href'));
                    $publicationParts = explode('-', $parts[2]);
                    $internalId       = $publicationParts[0];

                    $slug = str_replace('-highest-rated', '', $parts[2]);
                    $slug = preg_replace('/[0-9]+-/', '', $slug);

                    $publication = [
                        'name'        => $publicationName,
                        'slug'        => $slug,
                        'internal_id' => intval($internalId),
                        'list_url'    => $chartUrl,
                        'list_name'   => $publicationName . ' Highest Rated Albums of ' . $i,
                    ];

                    $this->info($publication['slug']);

//                    $this->info($publicationName . ' Highest Rated Albums of ' . $i);
                });
        }
    }
}

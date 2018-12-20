<?php

namespace App\Console\Commands\AOTY\Chart;

use App\Models\Music\Album;
use App\Models\Music\Artist;
use App\Models\Music\Chart;
use App\Models\Music\Genre;
use App\Models\Music\Score;
use App\Models\Music\Streaming;
use App\Models\Provider\Publication;
use App\Models\Type\ImageType;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ChartCrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoty:chart:batch';

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
        $charts = Chart::where([
            'provider_id' => config('clients.aoty.id'),
            'crawled_at'  => null,
        ])
            ->oldest('id')
            ->limit(200)
            ->get();

        foreach ($charts as $chart) {
            $this->crawl($chart);
        }
    }

    private function crawl($chart)
    {
        $page = 1;

        do {
            $currentUrl = $chart->url . $page;
            /** @var Crawler $crawler */
            if ($chart->tag_id != null) {
                $currentUrl .= '/';
            }
            $crawler = \Goutte::request('GET', $currentUrl);
            dump('URI url:', $currentUrl);
            dump('URI in crawler url:', $crawler->getUri());
            $noResultsMessage = $crawler->filter('.noResultsMessage')->count();
            if ($noResultsMessage) {
                $chart->update(['crawled_at' => now()]);
                return;
            }

            if ($chart->tag_id != null) {
                $headline = $crawler->filter('.headline')->text();
                if (!str_contains($headline, $chart->genre->name)) {
                    $chart->update(['crawled_at' => now()]);
                    return;
                }
            }

            if ($chart->publication_id != Publication::AOTY) {
                $logo = $crawler->filter('.logo')->count();
                if (!$logo) {
                    $chart->update(['crawled_at' => now()]);
                    return;
                };
            }

            $crawler->filter('.albumListRow')->each(
                function ($node) use ($chart, $page) {
                    $albumListTitle  = $node->filter('.albumListTitle');
                    $rank            = intval(str_replace('. ', '', $albumListTitle->filter('.albumListRank')->text()));
                    $albumInternalId = intval(explode('-', explode('/', $albumListTitle->filter('a')->attr('href'))[2])[0]);
                    $albumUrl        = config('clients.aoty.web_url') . $albumListTitle->filter('a')->attr('href');
                    $artistAlbum     = explode(' - ', $albumListTitle->filter('a')->text());
                    $artistName      = $artistAlbum[0];
                    $albumName       = $artistAlbum[1];
                    $coverUrl        = $node->filter('.albumListCover img')->attr('data-src');
                    $albumDate       = Carbon::parse($node->filter('.albumListDate')->text());
                    $scoreContainer  = $node->filter('.albumListScoreContainer');
                    $score           = intval($scoreContainer->filter('.scoreValueContainer .scoreValue')->text());

                    // Create artist
                    $artist = Artist::updateOrCreate(['name' => $artistName]);
                    $album  = $artist->albums()->whereName($albumName)->first();
                    if (!$album) {
                        $album = new Album([
                            'name' => $albumName,
                        ]);
                    }

                    $album->release_date = $albumDate;
                    $album->year         = $albumDate->year;

                    if ($album->isDirty()) {
                        $album->save();
                    }

                    $album->services()->updateOrCreate([
                        'provider_id' => config('clients.aoty.id'),
                        'web_url'     => $albumUrl,
                        'internal_id' => $albumInternalId,
                        'score'       => $score,
                    ]);

                    $artist->albums()->syncWithoutDetaching($album);
                    $album->images()->updateOrCreate([
                        'provider_id'   => config('clients.aoty.id'),
                        'image_type_id' => ImageType::THUMB,
                        'src'           => $coverUrl,
                    ]);

                    try {
                        $chart->albums()->save($album, [
                            'rank'  => $rank,
                            'score' => $score,
                        ]);
                    } catch (\Exception $e) {
                        $chart->albums()->updateExistingPivot($album, [
                            'rank'  => $rank,
                            'score' => $score,
                        ]);
                    }

                    $reviewCount = null;

                    if ($scoreContainer->filter('.scoreText strong')->count()) {
                        $reviewCount = intval($scoreContainer->filter('.scoreText strong')->text());
                    }

                    Score::updateOrCreate([
                        'owner_id'      => $chart->publication_id,
                        'owner_type'    => get_class($chart->publication),
                        'model_id'      => $album->id,
                        'model_type'    => get_class($album),
                        'score_type_id' => Score::CRITIC,
                        'points'        => $score,
                        'count'         => $reviewCount,
                    ]);


                    if ($node->filter('.albumListGenre a')->count()) {
                        $genreName = $node->filter('.albumListGenre a')->text();

                        $genre = Genre::whereSlug(str_slug($genreName))->first();

                        $album->genres()->syncWithoutDetaching($genre);
                    }

                    $node->filter('.albumListLinks a')->each(function ($link) use ($album) {
                        $url        = $link->attr('href');
                        $streamerId = $link->filter('div span')->text();
                        Streaming::updateOrCreate([
                            'streamer_type_id' => Streaming::$streamers[$streamerId],
                            'model_id'         => $album->id,
                            'model_type'       => get_class($album),
                            'url'              => $url,
                        ]);
                    });
                });

            $chart->update(['crawled_at' => now()]);

            $page++;
        } while ($currentUrl == $crawler->getUri());
    }
}

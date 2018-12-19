<?php

namespace App\Jobs\Lastfm\Artist;

use App\Http\Clients\Lastfm\LastfmClient;
use App\Repositories\Lastfm\ArtistRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $artist;

    /**
     * Create a new job instance.
     *
     * @param string $artist
     */
    public function __construct(string $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @param LastfmClient $client
     * @param ArtistRepository $artistRepository
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(LastfmClient $client, ArtistRepository $artistRepository)
    {
        $page = 1;

        do {
            dump("Page: $page");
            $results = $client->artist()
                ->search(urlencode($this->artist))
                ->limit(1000)
                ->page($page)
                ->get();

            foreach ($results['results']['artistmatches']['artist'] as $result) {
                if (isset($result['mbid']) && $result['mbid'] != '') {
                    $artist = $artistRepository->create($result);
                    dump($artist->name);
                    $artistRepository->addService($artist, $result);
                    // TODO: images
                }
            }

            $page++;
            $client->params['page'] = $page;
        } while (! empty($results['results']['artistmatches']['artist']));
    }
}

<?php

namespace App\Jobs\Musicbrainz\Artist;

use App\Http\Clients\Musicbrainz\MusicbrainzClient;
use App\Repositories\Musicbrainz\ArtistRepository;
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
     * @param MusicbrainzClient $client
     * @param ArtistRepository $artistRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(MusicbrainzClient $client, ArtistRepository $artistRepository)
    {
        $results = $client->artist()->search($this->artist)->get();

        foreach ($results['artists'] as $result) {
            $artist = $artistRepository->create($result);
            $artistRepository->addService($artist, $result);
        }
    }
}

<?php

namespace App\Jobs\Songkick\Artist;

use App\Http\Clients\Songkick\SongkickClient;
use App\Repositories\Songkick\ArtistRepository;
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
     * @param SongkickClient $client
     * @param ArtistRepository $artistRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(SongkickClient $client, ArtistRepository $artistRepository)
    {
        $results = $client->artist()->search($this->artist)->get();

        foreach ($results['resultsPage']['results']['artist'] as $result) {
            $artist = $artistRepository->create($result);
            $artistRepository->addService($artist, $result);
        }
    }
}

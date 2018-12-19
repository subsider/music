<?php

namespace App\Jobs\Bandsintown\Artist;

use App\Http\Clients\Bandsintown\BandsintownClient;
use App\Repositories\Bandsintown\ArtistRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistInfo implements ShouldQueue
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
     * @param BandsintownClient $client
     * @param ArtistRepository $artistRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(BandsintownClient $client, ArtistRepository $artistRepository)
    {
        $result = $client->artist()->info($this->artist)->get();

        if (! $result) return;

        $artist = $artistRepository->create($result);
        $artistRepository->addService($artist, $result);
        $artistRepository->addImages($artist, [
            'cover'   => $result['thumb_url'],
            'picture' => $result['image_url'],
        ]);
    }
}

<?php

namespace App\Jobs\Deezer\Album;

use App\Http\Clients\Deezer\DeezerClient;
use App\Jobs\Deezer\Traits\HasGuards;
use App\Repositories\Deezer\AlbumRepository;
use App\Repositories\Deezer\TrackRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAlbumTracks implements ShouldQueue
{
    use HasGuards, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private $id;

    /**
     * Create a new job instance.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param DeezerClient $client
     * @param AlbumRepository $albumRepository
     * @param TrackRepository $trackRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DeezerClient $client, AlbumRepository $albumRepository, TrackRepository $trackRepository)
    {
        $album = $this->guardAgainstNullAlbum();

        $results = $client->album()->tracks($this->id)->limit($client::MAX_LIMIT)->get();

        foreach ($results['data'] as $result) {
            $track = $albumRepository->addTrack($album, $result, $result['track_position']);
            $trackRepository->addService($track, $result);
        }
    }
}

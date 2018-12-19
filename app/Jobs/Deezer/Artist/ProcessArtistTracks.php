<?php

namespace App\Jobs\Deezer\Artist;

use App\Http\Clients\Deezer\DeezerClient;
use App\Repositories\Deezer\AlbumRepository;
use App\Repositories\Deezer\ArtistRepository;
use App\Repositories\Deezer\TrackRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistTracks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * @param ArtistRepository $artistRepository
     * @param AlbumRepository $albumRepository
     * @param TrackRepository $trackRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(
        DeezerClient $client,
        ArtistRepository $artistRepository,
        AlbumRepository $albumRepository,
        TrackRepository $trackRepository
    )
    {
        $results = $client->artist()->tracks($this->id)->limit(DeezerClient::MAX_LIMIT)->get();

        foreach ($results['data'] as $result) {
            $artist = $artistRepository->create($result['artist']);
            $artistRepository->addService($artist, $result['artist']);

            $album = $artistRepository->addAlbum($artist, $result['album']);
            $albumRepository->addService($album, $result['album']);
            $albumRepository->addImages($album, [
                'avatar'  => $result['album']['cover_small'],
                'cover'   => $result['album']['cover_medium'],
                'picture' => $result['album']['cover_big'],
                'large'   => $result['album']['cover_xl'],
            ]);

            $track = $albumRepository->addTrack($album, $result);
            $trackRepository->addService($track, $result);
            foreach ($result['contributors'] as $contributorResult) {
                $contributor = $artistRepository->create($contributorResult);
                $artistRepository->addService($contributor, $contributorResult);
                $artistRepository->addImages($contributor, [
                    'avatar'  => $contributorResult['picture_small'],
                    'cover'   => $contributorResult['picture_medium'],
                    'picture' => $contributorResult['picture_big'],
                    'large'   => $contributorResult['picture_xl'],
                ]);
                $trackRepository->addContributor($track, $contributor, $album, $contributorResult['role']);
            }
            $artist->tracks()->syncWithoutDetaching($track);
        }
    }
}

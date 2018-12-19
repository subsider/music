<?php

namespace App\Jobs\Deezer\Album;

use App\Http\Clients\Deezer\DeezerClient;
use App\Repositories\Deezer\AlbumRepository;
use App\Repositories\Deezer\ArtistRepository;
use App\Repositories\Deezer\TrackRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAlbumInfo implements ShouldQueue
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
        $result = $client->album()->info($this->id)
            ->get();

        if (isset($result['error'])) return;

        $artist = $artistRepository->create($result['artist']);
        $artistRepository->addService($artist, $result['artist']);
        $artistRepository->addImages($artist, [
            'avatar'  => $result['artist']['picture_small'],
            'cover'   => $result['artist']['picture_medium'],
            'picture' => $result['artist']['picture_big'],
            'large'   => $result['artist']['picture_xl'],
        ]);

        $album = $artistRepository->addAlbum($artist, $result);
        $albumRepository->addService($album, $result);
        $albumRepository->addImages($album, [
            'avatar'  => $result['cover_small'],
            'cover'   => $result['cover_medium'],
            'picture' => $result['cover_big'],
            'large'   => $result['cover_xl'],
        ]);

        foreach ($result['contributors'] as $contributorResult) {
            $contributor = $artistRepository->create($contributorResult);
            $artistRepository->addService($contributor, $contributorResult);
            $artistRepository->addImages($contributor, [
                'avatar'  => $contributorResult['picture_small'],
                'cover'   => $contributorResult['picture_medium'],
                'picture' => $contributorResult['picture_big'],
                'large'   => $contributorResult['picture_xl'],
            ]);
            $albumRepository->addContributor($album, $contributor, $contributorResult['role']);
        }

        foreach ($result['tracks']['data'] as $rank => $trackResult) {
            $track = $albumRepository->addTrack($album, $trackResult, $rank + 1);
            $trackRepository->addService($track, $trackResult);
            $artist->tracks()->syncWithoutDetaching($track);
        }

        $albumRepository->addLabel($album, $result['label']);

        foreach ($result['genres']['data'] as $genreResult) {
            $albumRepository->addTag($album, $genreResult['id'], $genreResult['picture']);
        }
    }
}

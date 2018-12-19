<?php

namespace App\Jobs\Deezer\Artist;

use App\Http\Clients\Deezer\DeezerClient;
use App\Jobs\Deezer\Traits\HasGuards;
use App\Models\Music\Radio;
use App\Repositories\Deezer\AlbumRepository;
use App\Repositories\Deezer\ArtistRepository;
use App\Repositories\Deezer\TrackRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistRadio implements ShouldQueue
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
        $artist = $this->guardAgainstNullArtist();

        $results = $client->artist()->radio($this->id)->limit(DeezerClient::MAX_LIMIT)->get();

        if (! isset($results['data'])) return;

        $radio = Radio::updateOrCreate([
            'radio_type_id' => Radio::TRACK,
            'provider_id'   => config('clients.deezer.id'),
            'name'          => config('clients.deezer.name') . " - " . $artist->name . ' Radio',
        ]);

        foreach ($results['data'] as $index => $result) {
            $artist = $artistRepository->create($result['artist']);
            $artistRepository->addService($artist, $result['artist']);
            $artistRepository->addImages($artist, [
                'avatar'  => $result['artist']['picture_small'],
                'cover'   => $result['artist']['picture_medium'],
                'picture' => $result['artist']['picture_big'],
                'large'   => $result['artist']['picture_xl'],
            ]);

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
            $artist->tracks()->syncWithoutDetaching($track);

            $radio->tracks()->syncWithoutDetaching($track);
        }
    }
}

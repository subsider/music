<?php

namespace App\Jobs\Deezer\Chart;

use App\Http\Clients\Deezer\DeezerClient;
use App\Models\Music\Chart;
use App\Models\People\Author;
use App\Repositories\Deezer\AlbumRepository;
use App\Repositories\Deezer\AuthorRepository;
use App\Repositories\Deezer\ChartRepository;
use App\Repositories\Deezer\TrackRepository;
use App\Repositories\Deezer\ArtistRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessChart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create Chart Tracks on a monthly basis
     *
     * @param DeezerClient $client
     * @param ArtistRepository $artistRepository
     * @param AlbumRepository $albumRepository
     * @param TrackRepository $trackRepository
     * @param AuthorRepository $authorRepository
     * @param ChartRepository $chartRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(
        DeezerClient $client,
        ArtistRepository $artistRepository,
        AlbumRepository $albumRepository,
        TrackRepository $trackRepository,
        AuthorRepository $authorRepository,
        ChartRepository $chartRepository
    )
    {
        $chartName = config('clients.deezer.name') .
            " - Top Tracks " .
            now()->format('F Y');

        $chart = Chart::updateOrCreate([
            'name'          => $chartName,
            'provider_id'   => config('clients.deezer.id'),
            'chart_type_id' => Chart::TRACK,
        ]);

        $results = $client->chart()->info()->limit(DeezerClient::MAX_LIMIT)->get();

        foreach ($results['tracks']['data'] as $result) {
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

            try {
                $chart->tracks()->save($track, ['rank' => $result['position']]);
            } catch (\Exception $e) {
                $chart->tracks()->updateExistingPivot($track, ['rank' => $result['position']]);
            }
        }

        $chartName = config('clients.deezer.name') .
            " - Top Albums " .
            now()->format('F Y');

        $chart = Chart::updateOrCreate([
            'name'          => $chartName,
            'provider_id'   => config('clients.deezer.id'),
            'chart_type_id' => Chart::ALBUM,
        ]);

        foreach ($results['albums']['data'] as $result) {
            $artist = $artistRepository->create($result['artist']);
            $artistRepository->addService($artist, $result['artist']);
            $artistRepository->addImages($artist, [
                'avatar'  => $result['artist']['picture_small'],
                'cover'   => $result['artist']['picture_medium'],
                'picture' => $result['artist']['picture_big'],
                'large'   => $result['artist']['picture_xl'],
            ]);

            $album = $artistRepository->addAlbum($artist, $result);
            $albumRepository->addService($album, $result['artist']);
            $albumRepository->addImages($album, [
                'avatar'  => $result['cover_small'],
                'cover'   => $result['cover_medium'],
                'picture' => $result['cover_big'],
                'large'   => $result['cover_xl'],
            ]);

            try {
                $chart->albums()->save($album, ['rank' => $result['position']]);
            } catch (\Exception $e) {
                $chart->albums()->updateExistingPivot($album, ['rank' => $result['position']]);
            }
        }

        $chartName = config('clients.deezer.name') .
            " - Top Artists " .
            now()->format('F Y');

        $chart = Chart::updateOrCreate([
            'name'          => $chartName,
            'provider_id'   => config('clients.deezer.id'),
            'chart_type_id' => Chart::ARTIST,
        ]);

        foreach ($results['artists']['data'] as $result) {
            $artist = $artistRepository->create($result);
            $artistRepository->addService($artist, $result);
            $artistRepository->addImages($artist, [
                'avatar'  => $result['picture_small'],
                'cover'   => $result['picture_medium'],
                'picture' => $result['picture_big'],
                'large'   => $result['picture_xl'],
            ]);

            try {
                $chart->artists()->save($artist, ['rank' => $result['position']]);
            } catch (\Exception $e) {
                $chart->artists()->updateExistingPivot($artist, ['rank' => $result['position']]);
            }
        }

        $chartName = config('clients.deezer.name') .
            " - Top Playlists " .
            now()->format('F Y');

        $chart = Chart::updateOrCreate([
            'name'          => $chartName,
            'provider_id'   => config('clients.deezer.id'),
            'chart_type_id' => Chart::PLAYLIST,
        ]);

        foreach ($results['playlists']['data'] as $index => $result) {
            $author = Author::updateOrCreate([
                'provider_id'   => config('clients.deezer.id'),
                'internal_id'   => $result['user']['id'],
                'username'      => $result['user']['name'],
                'tracklist_url' => $result['user']['tracklist'],
            ]);
            $playlist = $authorRepository->addPlaylist($author, $result);
            $chartRepository->addImages($playlist, [
                'avatar'  => $result['picture_small'],
                'cover'   => $result['picture_medium'],
                'picture' => $result['picture_big'],
                'large'   => $result['picture_xl'],
            ]);
            try {
                $chart->playlists()->save($playlist, ['rank' => $index + 1]);
            } catch (\Exception $e) {
                $chart->playlists()->updateExistingPivot($playlist, ['rank' => $index + 1]);
            }
        }
    }
}

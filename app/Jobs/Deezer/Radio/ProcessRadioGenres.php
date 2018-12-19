<?php

namespace App\Jobs\Deezer\Radio;

use App\Http\Clients\Deezer\DeezerClient;
use App\Models\Music\Genre;
use App\Models\Music\Radio;
use App\Repositories\Deezer\RadioRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessRadioGenres implements ShouldQueue
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

    public function handle(DeezerClient $client, RadioRepository $radioRepository)
    {
        $results = $client->radio()->genres()->limit($client::MAX_LIMIT)->get();

        foreach ($results['data'] as $genreResult) {
            $genre = Genre::whereSlug(str_slug($genreResult['title']))->first();

            foreach ($genreResult['radios'] as $result) {
                $radio = $radioRepository->create($result, Radio::TRACK);
                $radioRepository->addImages($radio, [
                    'avatar'  => $result['picture_small'],
                    'cover'   => $result['picture_medium'],
                    'picture' => $result['picture_big'],
                    'large'   => $result['picture_xl'],
                ]);

                $radio->genres()->syncWithoutDetaching($genre);
            }
        }
    }
}

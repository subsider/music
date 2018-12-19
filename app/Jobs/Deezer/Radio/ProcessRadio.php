<?php

namespace App\Jobs\Deezer\Radio;

use App\Http\Clients\Deezer\DeezerClient;
use App\Models\Music\Radio;
use App\Repositories\Deezer\RadioRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessRadio implements ShouldQueue
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
     * @param DeezerClient $client
     * @param RadioRepository $radioRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DeezerClient $client, RadioRepository $radioRepository)
    {
        $results = $client->radio()->top()->limit($client::MAX_LIMIT)->get();

        foreach ($results['data'] as $result) {
            $radio = $radioRepository->create($result, Radio::TRACK);
            $radioRepository->addImages($radio, [
                'avatar'  => $result['picture_small'],
                'cover'   => $result['picture_medium'],
                'picture' => $result['picture_big'],
                'large'   => $result['picture_xl'],
            ]);
        }
    }
}

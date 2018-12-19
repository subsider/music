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

class ProcessRadioInfo implements ShouldQueue
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
     * @param RadioRepository $radioRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DeezerClient $client, RadioRepository $radioRepository)
    {
        $result = $client->radio()->info($this->id)->get();

        if (isset($result['error'])) return;

        $radio = $radioRepository->create($result, Radio::TRACK);
        $radioRepository->addImages($radio, [
            'avatar'  => $result['picture_small'],
            'cover'   => $result['picture_medium'],
            'picture' => $result['picture_big'],
            'large'   => $result['picture_xl'],
        ]);
    }
}

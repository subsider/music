<?php

namespace App\Jobs\Deezer\Artist;

use App\Http\Clients\Deezer\DeezerClient;
use App\Jobs\Deezer\Traits\HasGuards;
use App\Repositories\Deezer\ArtistRepository;
use App\Repositories\Deezer\AuthorRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistComments implements ShouldQueue
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
     * @param AuthorRepository $authorRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DeezerClient $client, ArtistRepository $artistRepository, AuthorRepository $authorRepository)
    {
        $artist = $this->guardAgainstNullArtist();

        $results = $client->artist()->comments($this->id)
            ->limit(DeezerClient::MAX_LIMIT)
            ->get();

        foreach ($results['data'] as $result) {
            $author = $artistRepository->addAuthor($artist, $result['author']);
            $authorRepository->addImages($author, [
                'avatar'  => $result['author']['picture_small'],
                'cover'   => $result['author']['picture_medium'],
                'picture' => $result['author']['picture_big'],
                'large'   => $result['author']['picture_xl'],
            ]);
            $authorRepository->addComment($author, $artist, $result);
        }
    }
}

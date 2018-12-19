<?php

namespace App\Http\Clients\Songkick;

class ArtistResource
{
    /**
     * @var SongkickClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param SongkickClient $client
     */
    public function __construct(SongkickClient $client)
    {
        $this->client = $client;
    }

    public function search(string $artist)
    {
        $this->client->query = array_merge([
            'query' => $artist,
        ], $this->client->query);

        $this->client->url = 'search/artists.json';

        return $this->client;
    }
}

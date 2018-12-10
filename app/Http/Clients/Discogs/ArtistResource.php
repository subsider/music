<?php

namespace App\Http\Clients\Discogs;

class ArtistResource
{
    /**
     * @var DiscogsClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param DiscogsClient $client
     */
    public function __construct(DiscogsClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $artist
     * @return DiscogsClient
     */
    public function search(string $artist)
    {
        $this->client->query = array_merge([
            'q'    => $artist,
            'type' => 'artist',
        ], $this->client->query);

        $this->client->url = 'database/search';

        return $this->client;
    }
}

<?php

namespace App\Http\Clients\Lastfm;

class ArtistResource
{
    /**
     * @var LastfmClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param LastfmClient $client
     */
    public function __construct(LastfmClient $client)
    {
        $this->client = $client;
    }

    public function search(string $artist)
    {
        $this->client->params = array_merge([
            'method' => 'artist.search',
            'artist' => $artist,
        ], $this->client->params);

        return $this->client;
    }
}

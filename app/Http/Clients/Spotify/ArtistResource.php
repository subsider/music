<?php

namespace App\Http\Clients\Spotify;

class ArtistResource
{
    /**
     * @var SpotifyClient
     */
    private $client;

    /**
     * ArtistResource constructor.
     * @param SpotifyClient $client
     */
    public function __construct(SpotifyClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $artist
     * @return SpotifyClient
     */
    public function search(string $artist)
    {
        $this->client->query = [
            'type' => 'artist',
            'q'    => $artist,
        ];

        $this->client->url = 'search';

        return $this->client;
    }
}

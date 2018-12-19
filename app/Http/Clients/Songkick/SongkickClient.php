<?php

namespace App\Http\Clients\Songkick;

use GuzzleHttp\Client;

class SongkickClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    public $query;

    /**
     * @var string
     */
    public $url;

    /**
     * SongkickClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client(['base_uri' => config('clients.songkick.api_url')]);

        $this->query = [
            'apikey' => config('clients.songkick.api_key'),
        ];
    }

    /**
     * @return ArtistResource
     */
    public function artist()
    {
        return new ArtistResource($this);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        $response = $this->client->request('GET', $this->url, [
            'query' => $this->query,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}

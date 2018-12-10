<?php

namespace App\Http\Clients\Deezer;

use GuzzleHttp\Client;

class DeezerClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    public $url;

    /**
     * @var array
     */
    public $query;

    /**
     * BandsintownClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => config('clients.deezer.api_url')
        ]);
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
        $response = $this->client->request('GET', $this->url, $this->query);

        return json_decode($response->getBody()->getContents(), true);
    }
}

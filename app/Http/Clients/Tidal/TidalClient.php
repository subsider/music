<?php

namespace App\Http\Clients\Tidal;

use GuzzleHttp\Client;

class TidalClient
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
     * TidalClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => config('clients.tidal.api_url'),
            'headers' => [
                'X-Tidal-Token' => config('clients.tidal.api_key'),
            ],
        ]);

        $this->query = [
            'countryCode' => 'es',
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

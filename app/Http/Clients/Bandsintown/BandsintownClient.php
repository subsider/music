<?php

namespace App\Http\Clients\Bandsintown;

use GuzzleHttp\Client;

class BandsintownClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $query;

    /**
     * @var string
     */
    public $url;

    /**
     * BandsintownClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => config('clients.bandsintown.api_url')
        ]);

        $this->query = ['app_id' => config('clients.bandsintown.api_key')];
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

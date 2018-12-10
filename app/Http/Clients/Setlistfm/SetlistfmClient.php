<?php

namespace App\Http\Clients\Setlistfm;

use GuzzleHttp\Client;

class SetlistfmClient
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
     * SetlistfmClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => config('clients.setlistfm.api_url'),
            'headers'  => [
                'Accept'    => 'application/json',
                'x-api-key' => config('clients.setlistfm.api_key'),
            ],
        ]);
    }

    public function artist()
    {
        return new ArtistResource($this);
    }

    /**
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

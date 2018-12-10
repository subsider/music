<?php

namespace App\Http\Clients\Lastfm;

use GuzzleHttp\Client;

class LastfmClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    public $params;

    /**
     * LastfmClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->params = [
            'api_key' => config('clients.lastfm.api_key'),
            'format'  => 'json'
        ];
    }

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
        $response = $this->client->request('GET', config('clients.lastfm.api_url'), [
            'form_params' => $this->params,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}

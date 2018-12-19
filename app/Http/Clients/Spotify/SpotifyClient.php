<?php

namespace App\Http\Clients\Spotify;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class SpotifyClient
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
     * SpotifyClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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
        $token = $this->getToken();

        /** @var string $token */
        $response = $this->client->request(
            'GET',
            config('clients.spotify.api_url') . $this->url, [
            'query'   => $this->query,
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);

    }

    /**
     * @return \Illuminate\Contracts\Cache\Repository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getToken()
    {
        if (Cache::has('spotify_token')) {
            return Cache::get('spotify_token');
        }

        $tokenRequest = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
            'query'   => [
                'grant_type'    => 'client_credentials',
                'client_id'     => config('clients.spotify.client_id'),
                'client_secret' => config('clients.spotify.client_secret'),
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);

        $token = json_decode($tokenRequest->getBody()->getContents(), true)['access_token'];

        Cache::put('spotify_token', $token, 60);

        return $token;
    }
}

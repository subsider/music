<?php

return [
    'bandsintown' => [
        'api_url' => env('BANDSINTOWN_API_URL', 'https://rest.bandsintown.com/'),
        'api_key' => env('BANDSINTOWN_API_KEY'),
    ],

    'coverartarchive' => [
        'api_url' => env('COVERARTARCHIVE_API_URL', 'https://coverartarchive.org/release/'),
    ],

    'deezer' => [
        'api_url' => env('DEEZER_API_URL', 'https://api.discogs.com/'),
    ],

    'discogs' => [
        'api_url' => env('DISCOGS_API_URL', 'http://ws.audioscrobbler.com/2.0/'),
        'api_key' => env('DISCOGS_API_KEY'),
    ],

    'genius' => [
        'api_url' => env('GENIUS_API_URL', 'https://api.genius.com/'),
        'api_key' => env('GENIUS_API_KEY'),
    ],

    'itunes' => [

    ],

    'lastfm' => [
        'api_url' => env('LASTFM_API_URL', 'http://ws.audioscrobbler.com/2.0/'),
        'api_key' => env('LASTFM_API_KEY'),
    ],

    'musicbrainz' => [
        'api_url' => env('MUSICBRAINZ_API_URL', 'https://musicbrainz.org/ws/2/'),
    ],

    'napster' => [
        'api_url' => env('NAPSTER_API_URL', 'https://api.napster.com/v2.2/'),
        'api_key' => env('NAPSTER_API_KEY'),
    ],

    'setlistfm' => [
        'api_url' => env('SETLISTFM_API_URL', 'https://api.setlist.fm/rest/1.0/'),
        'api_key' => env('SETLISTFM_API_KEY'),
    ],

    'songkick' => [
        'api_url' => env('SONGKICK_API_URL', 'http://api.songkick.com/api/3.0/'),
        'api_key' => env('SONGKICK_API_KEY'),
    ],

    'spotify' => [
        'api_url' => env('SPOTIFY_API_URL', 'https://api.spotify.com/v1/'),
        'api_key' => env('SPOTIFY_API_KEY'),
    ],

    'tidal' => [
        'api_url' => env('TIDAL_API_URL', 'https://api.tidalhifi.com/v1/'),
        'api_key' => env('TIDAL_API_KEY'),
    ],
];

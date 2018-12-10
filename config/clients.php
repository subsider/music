<?php

return [
    'bandsintown' => [
        'id'      => 1,
        'name'    => 'Bandsintown',
        'api_url' => env('BANDSINTOWN_API_URL', 'https://rest.bandsintown.com/'),
        'api_key' => env('BANDSINTOWN_API_KEY'),
    ],

    'coverartarchive' => [
        'id'      => 2,
        'name'    => 'Cover Art Archive',
        'api_url' => env('COVERARTARCHIVE_API_URL', 'https://coverartarchive.org/release/'),
    ],

    'deezer' => [
        'id'      => 3,
        'name'    => 'Deezer',
        'web_url' => env('DEEZER_WEB_URL', 'https://deezer.com/'),
        'api_url' => env('DEEZER_API_URL', 'https://api.deezer.com/'),
    ],

    'discogs' => [
        'id'         => 4,
        'name'       => 'Discogs',
        'web_url'    => env('DISCOGS_WEB_URL', 'https://www.discogs.com'),
        'api_url'    => env('DISCOGS_API_URL', 'https://api.discogs.com/'),
        'api_key'    => env('DISCOGS_API_KEY'),
        'api_secret' => env('DISCOGS_API_SECRET'),
    ],

    'genius' => [
        'id'      => 5,
        'name'    => 'Genius',
        'web_url' => env('GENIUS_WEB_URL', 'https://genius.com/'),
        'api_url' => env('GENIUS_API_URL', 'https://api.genius.com/'),
        'api_key' => env('GENIUS_API_KEY'),
    ],

    'itunes' => [
        'id'      => 6,
        'name'    => 'iTunes',
        'web_url' => env('ITUNES_WEB_URL', 'https://itunes.apple.com/'),
        'api_url' => env('ITUNES_API_URL', 'https://itunes.apple.com/'),
    ],

    'lastfm' => [
        'id'      => 7,
        'name'    => 'Lastfm',
        'api_url' => env('LASTFM_API_URL', 'http://ws.audioscrobbler.com/2.0/'),
        'api_key' => env('LASTFM_API_KEY'),
    ],

    'musicbrainz' => [
        'id'      => 8,
        'name'    => 'Musicbrainz',
        'api_url' => env('MUSICBRAINZ_API_URL', 'https://musicbrainz.org/ws/2/'),
    ],

    'napster' => [
        'id'      => 9,
        'name'    => 'Napster',
        'api_url' => env('NAPSTER_API_URL', 'https://api.napster.com/v2.2/'),
        'api_key' => env('NAPSTER_API_KEY'),
    ],

    'setlistfm' => [
        'id'      => 10,
        'name'    => 'Setlistfm',
        'api_url' => env('SETLISTFM_API_URL', 'https://api.setlist.fm/rest/1.0/'),
        'api_key' => env('SETLISTFM_API_KEY'),
    ],

    'songkick' => [
        'id'      => 11,
        'name'    => 'Songkick',
        'api_url' => env('SONGKICK_API_URL', 'http://api.songkick.com/api/3.0/'),
        'api_key' => env('SONGKICK_API_KEY'),
    ],

    'spotify' => [
        'id'      => 12,
        'name'    => 'Spotify',
        'api_url' => env('SPOTIFY_API_URL', 'https://api.spotify.com/v1/'),
        'api_key' => env('SPOTIFY_API_KEY'),
    ],

    'tidal' => [
        'id'      => 13,
        'name'    => 'Tidal',
        'api_url' => env('TIDAL_API_URL', 'https://api.tidalhifi.com/v1/'),
        'api_key' => env('TIDAL_API_KEY'),
    ],
];

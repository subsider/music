<?php

namespace App\Jobs\Bandsintown\Artist;

use App\Http\Clients\Bandsintown\BandsintownClient;
use App\Models\Geo\Area;
use App\Models\Geo\Country;
use App\Models\Geo\Place;
use App\Repositories\Bandsintown\ArtistRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessArtistEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $artist;

    /**
     * Create a new job instance.
     *
     * @param string $artist
     */
    public function __construct(string $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @param BandsintownClient $client
     * @param ArtistRepository $artistRepository
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(BandsintownClient $client, ArtistRepository $artistRepository)
    {
        $results = $client->artist()->events($this->artist)->get();

        $artist = $artistRepository->create(['name' => ucwords(urldecode($this->artist))]);

        if (empty($results)) {
            $artist->update(['upcoming_event_count' => 0]);
            return;
        }

        $artistRepository->addService($artist, [
            'internal_id' => $results[0]['artist_id'],
            'url'         => config('clients.bandsintown.web_url') . "/a/{$results[0]['artist_id']}",
        ]);

        foreach ($results as $result) {
            $code = null;
            $country = Country::whereName($result['venue']['country'])->first();

            if ($country) $code = $country->code;

            $city = Area::firstOrCreate([
                'area_type_id' => 1,
                'country_code' => $code,
                'name'         => $result['venue']['city'],
            ]);

            if (isset($result['venue']['region']) && $result['venue']['region'] != '') {
                $city->region = $result['venue']['region'];
            }

            if ($city->isDirty()) {
                $city->save();
            }

            $venue = Place::updateOrCreate([
                'area_id'       => $city->id,
                'place_type_id' => 1,
                'name'          => $result['venue']['name'],
            ]);

            if (isset($result['venue']['latitude'])) {
                $venue->latitude = $result['venue']['latitude'];
            }

            if (isset($result['venue']['longitude'])) {
                $venue->longitude = $result['venue']['longitude'];
            }

            if ($venue->isDirty()) {
                $venue->save();
            }

            $venue->services()->updateOrCreate([
                'provider_id' => config('clients.bandsintown.id'),
            ]);

            $event = $venue->events()->firstOrCreate([
                'place_id'         => $venue->id,
                'celebration_date' => Carbon::parse($result['datetime']),
            ]);

            if (isset($result['description']) && $result['description'] != '') {
                $event->description = $result['description'];
            }

            if (isset($result['on_sale_datetime']) && $result['on_sale_datetime'] != '') {
                $event->on_sale_date = Carbon::parse($result['on_sale_datetime']);
            }

            if ($event->isDirty()) {
                $event->save();
            }

            $event->services()->updateOrCreate([
                'provider_id' => config('clients.bandsintown.id'),
            ], [
                'internal_id' => $result['id'],
                'web_url'     => strtok($result['url'], '?'),
                'api_url'     => strtok(config('clients.bandsintown.api_url') . 'artists/' . $artist->name, '?'),
            ]);

            foreach ($result['lineup'] as $performance) {
                $lineupArtist = $artistRepository->create(['name' => $performance]);
                $event->artists()->syncWithoutDetaching($lineupArtist);
            }

            if (isset($result['offers']) && !empty($result['offers'])) {
                foreach ($result['offers'] as $offerResult) {
                    $event->offers()->updateOrCreate([
                        'type'   => $offerResult['type'],
                        'url'    => strtok($result['url'], '?'),
                        'status' => $offerResult['status'],
                    ]);
                }
            }
        }
    }
}

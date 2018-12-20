<?php

namespace App\Console\Commands\AOTY\Chart;

use App\Models\Music\Chart;
use App\Models\Music\Genre;
use App\Models\Provider\Publication;
use Illuminate\Console\Command;

class ChartGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoty:chart:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $genres = Genre::whereHas('services', function ($service) {
            $service->where('provider_id', config('clients.aoty.id'));
        })->with('services')->get();

        $publications = Publication::all();

        for ($year = now()->year; $year >= 1990; $year--) {
            $this->warn('Starting year ' . $year);
            foreach ($publications as $publication) {
                $this->warn('Starting publication ' . $publication->name);
                $separator = $publication->aoty_id == 6 ? '' : '-';
                Chart::updateOrCreate([
                    'provider_id'    => config('clients.aoty.id'),
                    'chart_type_id'  => Chart::ALBUM,
                    'publication_id' => $publication->id,
                    'name'           => $publication->name . ' - Highest Rated Albums of ' . $year,
                    'url'            => config('clients.aoty.web_url') . '/ratings/' . $publication->aoty_id . $separator . $publication->slug . '-highest-rated/' . $year . '/',
                ]);
            }

            foreach ($genres as $genre) {
                $service = $genre->services()->where('provider_id', config('clients.aoty.id'))->first();
                $this->warn('Starting genre ' . $genre->name . ' for year ' . $year);
                Chart::updateOrCreate([
                    'provider_id'    => config('clients.aoty.id'),
                    'chart_type_id'  => Chart::ALBUM,
                    'publication_id' => Publication::AOTY,
                    'tag_id'         => $genre->id,
                    'name'           => 'Album of the Year - Highest Rated ' . $genre->name . ' Albums of ' . $year,
                    'url'            => $service->web_url  . $year . '/',
                ]);
            }
        }
    }
}

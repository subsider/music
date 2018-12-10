<?php

use App\Models\Provider\Provider;
use Illuminate\Database\Migrations\Migration;

class AddDefaultProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (config('clients') as $client) {
            Provider::create([
                'name'    => $client['name'],
                'api_url' => $client['api_url'] ?? null,
                'web_url' => $client['web_url'] ?? null,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Provider::truncate();
    }
}

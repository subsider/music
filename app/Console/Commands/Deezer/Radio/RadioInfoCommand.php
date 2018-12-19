<?php

namespace App\Console\Commands\Deezer\Radio;

use App\Jobs\Deezer\Radio\ProcessRadioInfo;
use Illuminate\Console\Command;

class RadioInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deezer:radio:info {id}';

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
        ProcessRadioInfo::dispatch($this->argument('id'));
    }
}

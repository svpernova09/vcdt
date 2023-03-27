<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use VCDT\Services\ProcessBoxes;

class FetchStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Stats';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $run = new ProcessBoxes();
        $run();
    }
}

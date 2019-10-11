<?php

namespace App\Console\Commands;

use App\Supports\Configuration;
use Illuminate\Console\Command;

class maintenanceMode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:mode {mode}';

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
     * @param Configuration $configuration
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(Configuration $configuration)
    {
        $mode = $this->argument('mode');

        $maintenanceMode = ['admin' => ['maintenanceMode' => false]];
        if ($mode == 'up') {
            $maintenanceMode['admin']['maintenanceMode'] = true;
        }

        $configuration->set($maintenanceMode);
    }
}

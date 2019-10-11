<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class Npm extends Command
    {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'npm {cmd}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'NPM Commands';

    /**
     * Allowed NPM Commands
     *
     * @var array
     */
    protected $allowedCommands = ['install', 'update', 'run'];

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
     */
    public function handle()
    {
        $npmCommand = $this->argument('cmd');

        if (!in_array($npmCommand, $this->allowedCommands)) {
            $this->error(trans('error.npm_cmd_failed'));
            die();
        }

        if ($npmCommand == 'run') {
            $environment = config('app.env');
            $npmCommand  = 'run prod';
            if ($environment != 'production') {
                $npmCommand = 'run dev';
            }
        }

        $projectPatch = app()->basePath();
        $command      = 'cd ' . $projectPatch . ' && npm ' . $npmCommand;

        exec($command, $output, $status);

        if ($status != 0){
            logger()->error('NPM running error, error code: ' . $status);
            die();
        }

        info('NPM running success,', $output);
    }
}

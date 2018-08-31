<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate And Run Tests';

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
        $this->callSilent('migrate:fresh', [
            '--seed' => NULL,
            '--env' => 'testing'
        ]);

        $this->call('./vendor/bin/phpunit');
    }
}

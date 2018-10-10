<?php

namespace Launcher\Mercurius\Commands;

use Illuminate\Console\Command;
use Launcher\Mercurius\MercuriusServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mercurius:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Mercurius Messenger package';

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
        $this->info('Installing Mercurius Messenger');

        $this->call('vendor:publish', [
            '--provider' => MercuriusServiceProvider::class,
            '--tag'      => [
                'mercurius-public',
                'mercurius-migrations',
                'mercurius-seeds',
                'mercurius-lang',
            ],
        ]);

        $this->info('Migrating the database');
        $this->call('migrate');

        $this->info('Mercurius messenger installed. Have fun!');
    }
}

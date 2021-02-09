<?php

namespace JetBox\Permission\Console\Commands;

use Illuminate\Console\Command;
use JetBox\Permission\PermissionServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Permission Package';

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
     * @return void
     */
    public function handle()
    {
        $this->info('Publishing the Permission database, and config files');
        $this->call('vendor:publish', [
            '--provider' => PermissionServiceProvider::class
        ]);

        $this->info('Migrating the database tables into your application');
        $this->call('migrate');

        $this->info('Successfully installed Permission! Enjoy');
    }
}

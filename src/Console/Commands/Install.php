<?php

namespace ProcessMaker\Package\BusinessRules\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Facades\ProcessMaker\Package\BusinessRules\Seeds\BusinessRulePermissionSeeder;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo-package:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Demo Package';

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
        $this->info('Publishing assets');
        Artisan::call('vendor:publish', [
            '--tag' => 'business-rules',
            '--force' => true
        ]);

        $this->info('Adding database tables');
        $this->installMigrations([
            __DIR__ . '/../../../database/migrations',
        ]);

        $this->info('Update permissions');
        BusinessRulePermissionSeeder::update();

        $this->info('Demo package has been installed');
    }

    /**
     * Install migrations
     *
     * @param array $pluginMigrationsPaths
     * @return void
     */
    private function installMigrations(array $pluginMigrationsPaths)
    {
        $migrator = app('migrator');
        $migrator->run($pluginMigrationsPaths);
    }
}

<?php

namespace ProcessMaker\Package\BusinessRules\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Facades\ProcessMaker\Package\BusinessRules\Seeds\BusinessRulePermissionSeeder;

class Uninstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business-rules:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall Business Rules Package';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //remove migrations
        $this->uninstallMigrations([
            __DIR__ . '/../../../database/migrations',
        ]);

        //remove permissions
        BusinessRulePermissionSeeder::delete();

        // Remove the vendor assets
        File::deleteDirectory(public_path('vendor/processmaker/connectors/business-rules'));

        $this->info('Bussines Rules Package was uninstalled');
    }

    /**
     * Install migrations
     *
     * @param array $pluginMigrationsPaths
     * @return void
     */
    private function uninstallMigrations(array $pluginMigrationsPaths)
    {
        $migrator = app('migrator');
        $migrator->rollback($pluginMigrationsPaths);
    }

}

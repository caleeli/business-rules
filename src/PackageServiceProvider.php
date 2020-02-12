<?php
namespace ProcessMaker\Package\BusinessRules;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use ProcessMaker\Package\Packages\Events\PackageEvent;
use ProcessMaker\Package\BusinessRules\Http\Middleware\AddToMenus;
use ProcessMaker\Package\BusinessRules\Listeners\PackageListener;
use ProcessMaker\Package\BusinessRules\Seeds\BusinessRulePermissionSeeder;
use ProcessMaker\Traits\PluginServiceProviderTrait;

class PackageServiceProvider extends ServiceProvider
{
    use PluginServiceProviderTrait;

    // Assign the default namespace for our controllers
    protected $namespace = '\ProcessMaker\Package\BusinessRules\Http\Controllers';

    /**
     * If your plugin will provide any services, you can register them here.
     * See: https://laravel.com/docs/5.6/providers#the-register-method
     */
    public function register()
    {
        // Nothing is registered at this time
    }

    /**
     * After all service provider's register methods have been called, your boot method
     * will be called. You can perform any initialization code that is dependent on
     * other service providers at this time.  We've included some example behavior
     * to get you started.
     *
     * See: https://laravel.com/docs/5.6/providers#the-boot-method
     */
    public function boot()
    {
        $this->commands([
            Console\Commands\Install::class,
            Console\Commands\Uninstall::class,
        ]);

        // Assigning to the web middleware will ensure all other middleware assigned to 'web'
        // will execute. If you wish to extend the user interface, you'll use the web middleware
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/web.php');

        //route api
        Route::middleware('api')
            ->namespace($this->namespace)
            ->prefix('api/1.0')
            ->group(__DIR__ . '/../routes/api.php');

        //menus
        Route::pushMiddlewareToGroup('web', AddToMenus::class);

        //load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        //Register a seeder that will be executed in php artisan db:seed
        $this->registerSeeder(BusinessRulePermissionSeeder::class);

        //load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'business-rules');

        //publish assets
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/processmaker/packages/business-rules'),
        ], 'business-rules');

    }
}

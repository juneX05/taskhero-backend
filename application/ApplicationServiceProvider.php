<?php
namespace Application;


use App\Http\Kernel;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class ApplicationServiceProvider extends ServiceProvider
{

    public function boot(Kernel $kernel)
    {
        $kernel->prependMiddlewareToGroup('api', EnsureFrontendRequestsAreStateful::class);
//        $kernel->appendToMiddlewarePriority(ApplicationGatesMiddleware::class);
        $kernel->appendMiddlewareToGroup('api',ApplicationGatesMiddleware::class);

//        $this->app->singleton('module_directories', function(){
//            return ApplicationBootstrapper::getApplicationModules();
//        });
//
//        $this->app->singleton('module_directories_list', function(){
//            return ApplicationBootstrapper::getApplicationModulesList();
//        });

        //Exception Handling Changes.
        $this->app->singleton(
            ExceptionHandler::class,
            ApplicationExceptionHandler::class
        );

        $this->processModules();
    }

    public function register()
    {
        //
    }

    private function processModules() {
        $module_directories = ApplicationBootstrapper::getApplicationModulesList();

        foreach ($module_directories as $directory) {
            ApplicationBootstrapper::getRoutes($directory);
            $this->loadMigrationsFrom($directory . '/Migrations');
        }

        ApplicationBootstrapper::getRoutes(base_path('/application'));

        ApplicationBootstrapper::setUpConfigurations();
    }

}

<?php


namespace Application;


use Application\Modules\Core\Users\Users_Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class ApplicationBootstrapper
{
    private static function applicationModuleDirectories()
    {
        return [
            'core_modules' => core_modules_path(),
            'system_modules' => system_modules_path(),
        ];
    }

    public static function getApplicationModules()
    {
        $module_directories = self::applicationModuleDirectories();
        $modules = [];
        foreach ($module_directories as $key => $directory) {
            $modules[$key] = File::directories($directory);
        }
        return $modules;
    }

    public static function getApplicationModulesList()
    {
        $module_directories = self::applicationModuleDirectories();
        $modules = [];
        foreach ($module_directories as $key => $directory) {
            $modules = array_merge($modules, File::directories(($directory)));
        }
        return $modules;
    }

    public static function getRoutes($directory)
    {
        $files = File::allFiles($directory);

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $filepath = $file->getPathname();
            if ($filename == '__routes.php') {
                Route::prefix('api')
                    ->middleware('api')
                    ->namespace(null)
                    ->group($filepath);
            }
        }

    }

    public static function setUpConfigurations()
    {
        Config::set('auth.providers.users', [
            'driver' => 'eloquent',
            'model' => Users_Model::class,
        ]);

        Config::set('database.connections.db_log', [
            'driver' => 'sqlite',
            'url' => env('LOG_DATABASE_URL'),
            'database' => database_path(env('LOG_DB_DATABASE', 'db_log.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);

        if (!file_exists(database_path('database.sqlite'))) {
            file_put_contents(database_path('database.sqlite'),'');
        }

        if (!file_exists(database_path('database_testing.sqlite'))) {
            file_put_contents(database_path('database_testing.sqlite'),'');
        }

        if (!file_exists(database_path('db_log.sqlite'))) {
            file_put_contents(database_path('db_log.sqlite'),'');
        }

        if (!file_exists(database_path('db_log_testing.sqlite'))) {
            file_put_contents(database_path('db_log_testing.sqlite'),'');
        }

        $allowed_origins = Config::get('cors.allowed_origins');
        $allowed_origins = array_merge($allowed_origins, [
            'http://127.0.0.1:5173', 'localhost'
        ]);

        Config::set('cors.allowed_origins', $allowed_origins);
        Config::set('cors.supports_credentials', true);

//        https://stackoverflow.com/questions/48101728/save-files-with-storeas-outside-the-storage-folder
        $disks = Config::get('filesystems.disks');
        $disks = array_merge($disks, [
            'uploads' => [
                'driver' => 'local',
                'root' => uploads_path()
            ]
        ]);
        Config::set('filesystems.disks', $disks);

    }
}

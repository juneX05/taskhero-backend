<?php


namespace Application;


use Application\Modules\Core\Users\Users_Model;
use Illuminate\Database\Schema\Blueprint;
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

    public static function initModules(ApplicationServiceProvider $provider) {

        $module_directories = self::getApplicationModulesList();

        foreach ($module_directories as $directory) {
            self::processModule($directory, $provider);
        }

        ApplicationBootstrapper::getRoutes(base_path('/application'));

        ApplicationBootstrapper::setUpConfigurations();
    }

    private static function processModule($directory, ApplicationServiceProvider $provider){
        //1. begin module processing
        ApplicationBootstrapper::getRoutes($directory);

        $provider->migrationsLoader($directory);

        //2. CHECK IF MODULE HAS INNER MODULES AND PROCESS THEM

        if (is_dir($directory . '/_Modules')) {

            $module_directories = File::directories($directory . '/_Modules');

            foreach ($module_directories as $directory) {
                self::processModule($directory, $provider);
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

//        $allowed_origins = Config::get('cors.allowed_origins');
        $allowed_origins = array_merge( explode(',', env('ALLOWED_ORIGINS')) ?? []);

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

    public static function processMigrationColumns(Blueprint $table, $column) {
        $definition = null;

        $name = $column['name'];
        $type = $column['type'];
        $auto_increment = $column['auto_increment'] ?? null;
        $nullable = $column['nullable'] ?? null;
        $unique = $column['unique'] ?? null;
        $default = $column['default'] ?? null;

        if ($name == 'id') {
            if ($auto_increment) {
                $table->id();
            } else {
                $table->integer($name)->primary();
            }
            return $table;
        }

        if ($type == 'integer'){
            $definition = $table->integer($name);
        }

        if ($type == 'date'){
            $definition = $table->date($name);
        }

        if ($type == 'date_time'){
            $definition = $table->dateTime($name);
        }

        if ($type == 'string'){
            $definition = $table->string($name);
        }

        if ($type == 'text'){
            $definition = $table->text($name);
        }

        if ($type == 'long_text'){
            $definition = $table->longText($name);
        }

        if ($type == 'time'){
            $definition = $table->time($name);
        }

        if ($type == 'timestamp'){
            $definition = $table->timestamp($name);
        }

        if ($auto_increment != null) {
            $definition->autoIncrement();
        }

        if ($nullable != null) {
            if ($nullable == true) {
                $definition->nullable();
            } else {
                $definition->nullable(false);
            }
        }

        if ($unique != null) {
            if ($unique == true) {
                $definition->unique();
            }
        }

        if ($default != null) {
            $definition->default($default);
        }

        return $table;
    }

    public static function setupFillables($columns) {
        $fillables = ['urid'];
        foreach ($columns as $column) {
            if (isset($column['fillable'])) $fillables[] = $column['name'];
        }
        return $fillables;
    }
}

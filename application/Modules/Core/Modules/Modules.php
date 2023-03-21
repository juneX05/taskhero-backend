<?php

namespace Application\Modules\Core\Modules;

class Modules
{
    public static function runMigration() {
        if (\Auth::id() == 1) {
            exec('php artisan migrate --path=/database/migrations/full_migration_file_name_migration.php');
        }
    }

    public static function runSeeder($class) {
        echo "php artisan db:seed --class=$class";
        echo getcwd();
        if (\Auth::id() == 1) {
            exec("php ../artisan db:seed --class=$class", $output);
            echo json_encode($output);
        }
    }
}

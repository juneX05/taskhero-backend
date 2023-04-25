<?php

namespace Application\Modules\Core\Modules;

use Application\Modules\SystemSeeder;

class Modules
{
    public static function runMigration() {
        if (\Auth::id() == 1) {
            exec('php artisan migrate --path=/database/migrations/full_migration_file_name_migration.php');
        }
    }

    public static function runSeeder($module) {
        if (\Auth::id() == 1) {
            SystemSeeder::seedModule($module);
        }
    }
}

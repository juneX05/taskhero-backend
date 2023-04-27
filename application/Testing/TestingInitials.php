<?php


namespace Application\Testing;


class TestingInitials
{
    public static function controlTestEnvironment($start = true) {

        if ($start) {
            system('php artisan migrate:fresh --path=application/Modules/Core/Logs/Migrations/logs --database=db_log', $result);
            if ($result != 0) exit;

            system('php artisan migrate:fresh', $result);
            if ($result != 0) exit;

            system('php artisan db:seed Application\Modules\SystemSeeder', $result);
            if ($result != 0) exit;
        }
    }
}

<?php
namespace Tests;
use Illuminate\Support\Facades\Artisan;

trait MigrateFreshSeedOnce {
    public static function controlTestEnvironment($start = true) {
        $file = __DIR__ .'/../application/testing.json';
        $file_data = json_decode(file_get_contents($file), true);

        $file_data['testing'] = $start;

        file_put_contents($file, json_encode($file_data));

        if ($start) {
            exec("php artisan migrate:fresh --seed", $output);
            echo json_encode($output, JSON_PRETTY_PRINT);

            exec("php artisan migrate:fresh --path=application/Modules/Core/Logs/Migrations/logs --database=db_log", $output);
            echo json_encode($output, JSON_PRETTY_PRINT);
        }
    }

    /**
     * If true, setup has run at least once.
     * @var boolean
     */
    protected static $setUpHasRunOnce = false;
    /**
     * After the first run of setUp "migrate:fresh --seed"
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setUpHasRunOnce) {
//            Artisan::call('migrate:fresh');
//            Artisan::call(
//                'db:seed', ['--class' => 'DatabaseSeeder']
//            );

            self::controlTestEnvironment(true);
            static::$setUpHasRunOnce = true;
        }
    }

    public function tearDown(): void
    {
        parent::tearDown();

        self::controlTestEnvironment(false);
    }
}

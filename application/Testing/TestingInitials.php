<?php


namespace Application\Testing;


class TestingInitials
{
    public static function controlTestEnvironment($start = true) {
        $file = __DIR__ . '/../application/testing.json';
        $file_data = json_decode(file_get_contents($file), true);

        $file_data['testing'] = $start;

        file_put_contents($file, json_encode($file_data));

        if ($start) {
            exec("php artisan migrate:fresh --seed", $output);
            echo json_encode($output, JSON_PRETTY_PRINT);
        }
    }
}

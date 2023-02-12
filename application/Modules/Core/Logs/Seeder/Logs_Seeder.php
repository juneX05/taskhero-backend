<?php

namespace Application\Modules\Core\Logs\Seeder;

use Application\Modules\Core\Logs\Logs_Model;
use Illuminate\Database\Seeder;

class Logs_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Logs');

        //seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Logs_Model::create($record);
        }
    }
}

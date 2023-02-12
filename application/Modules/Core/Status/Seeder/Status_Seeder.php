<?php

namespace Application\Modules\Core\Status\Seeder;

use Application\Modules\Core\Status\Status_Model;
use Illuminate\Database\Seeder;

class Status_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Status');

        //seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Status_Model::create($record);
        }
    }
}

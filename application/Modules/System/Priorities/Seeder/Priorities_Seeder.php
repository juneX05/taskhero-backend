<?php

namespace Application\Modules\System\Priorities\Seeder;

use Application\Modules\System\Priorities\Priorities_Model;
use Application\Modules\System\Priorities\Priority_Model;
use Illuminate\Database\Seeder;

class Priorities_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Priorities');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Priorities_Model::create($record);
        }
    }
}

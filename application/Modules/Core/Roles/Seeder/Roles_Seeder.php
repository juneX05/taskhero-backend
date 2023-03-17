<?php

namespace Application\Modules\Core\Roles\Seeder;

use Application\Modules\Core\Roles\Roles_Model;
use Illuminate\Database\Seeder;

class Roles_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Roles');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Roles_Model::create($record);
        }
    }
}

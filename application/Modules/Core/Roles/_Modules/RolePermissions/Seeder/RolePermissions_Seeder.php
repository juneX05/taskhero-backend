<?php

namespace Application\Modules\Core\Roles\_Modules\RolePermissions\Seeder;

use Application\Modules\Core\Roles\_Modules\RolePermissions\RolePermissions_Model;
use Illuminate\Database\Seeder;

class RolePermissions_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Roles/_Modules/RolePermissions');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            RolePermissions_Model::create($record);
        }
    }
}

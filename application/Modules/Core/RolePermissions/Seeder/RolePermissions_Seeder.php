<?php

namespace Application\Modules\Core\RolePermissions\Seeder;

use Application\Modules\Core\RolePermissions\RolePermissions_Model;
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
        $seeder_data = getSeederData('RolePermissions');

        //seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            RolePermissions_Model::create($record);
        }
    }
}

<?php

namespace Application\Modules\Core\Permissions\_Modules\PermissionStatus\Seeder;

use Application\Modules\Core\Permissions\_Modules\PermissionStatus\PermissionStatus_Model;
use Illuminate\Database\Seeder;

class PermissionStatus_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Permissions/_Modules/PermissionStatus');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            PermissionStatus_Model::create($record);
        }
    }
}

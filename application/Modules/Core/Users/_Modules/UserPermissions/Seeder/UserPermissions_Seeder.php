<?php

namespace Application\Modules\Core\Users\_Modules\UserPermissions\Seeder;

use Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions_Model;
use Illuminate\Database\Seeder;

class UserPermissions_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Users/_Modules/UserPermissions');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            UserPermissions_Model::create($record);
        }
    }
}

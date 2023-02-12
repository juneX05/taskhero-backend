<?php

namespace Application\Modules\Core\UserRoles\Seeder;

use Application\Modules\Core\UserRoles\UserRoles_Model;
use Illuminate\Database\Seeder;

class UserRoles_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('UserRoles');

        //seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            UserRoles_Model::create($record);
        }
    }
}

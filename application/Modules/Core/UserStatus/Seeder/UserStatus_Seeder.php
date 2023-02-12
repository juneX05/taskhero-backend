<?php

namespace Application\Modules\Core\UserStatus\Seeder;

use Application\Modules\Core\UserStatus\UserStatus_Model;
use Illuminate\Database\Seeder;

class UserStatus_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('UserStatus');

        //seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            UserStatus_Model::create($record);
        }
    }
}

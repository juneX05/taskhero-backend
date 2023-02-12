<?php

namespace Application\Modules\Core\UserTypes\Seeder;

use Application\Modules\Core\UserTypes\UserTypes_Model;
use Illuminate\Database\Seeder;

class UserTypes_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('UserTypes');

        //seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            UserTypes_Model::create($record);
        }
    }
}

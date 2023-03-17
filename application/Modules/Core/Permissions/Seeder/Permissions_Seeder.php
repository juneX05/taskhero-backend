<?php

namespace Application\Modules\Core\Permissions\Seeder;

use Application\Modules\Core\Permissions\Permissions_Model;
use Illuminate\Database\Seeder;

class Permissions_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Permissions');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['data']); //special case :)
//        $this->seedData($seeder_data['data']);
    }

//    private function seedData($records) {
//        foreach ($records as $record) {
//            Permissions_Model::create($record);
//        }
//    }
}

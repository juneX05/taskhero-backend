<?php

namespace Application\Modules\Core\Auth\Seeder;

use Application\Modules\Core\Modules\Modules_Model;
use Illuminate\Database\Seeder;

class Auth_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Auth');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
//        $this->seedData($seeder_data['data']);
    }

//    private function seedData($records) {
//        foreach ($records as $record) {
//            Modules_Model::create($record);
//        }
//    }
}

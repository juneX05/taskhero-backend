<?php

namespace Application\Modules\Core\Users\Seeder;

use Application\Modules\Core\Users\Users_Model;
use Illuminate\Database\Seeder;

class Users_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Users');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            $record['password'] = bcrypt($record['password']);
            Users_Model::create($record);
        }
    }
}

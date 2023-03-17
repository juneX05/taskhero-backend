<?php

namespace Application\Modules\Core\Menus\Seeder;

use Application\Modules\Core\Menus\Menus_Actions;
use Application\Modules\Core\Menus\Menus_Model;
use Illuminate\Database\Seeder;

class Menus_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Menus');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Menus_Model::insert($record);
        }
    }
}

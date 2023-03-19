<?php

namespace Application\Modules\System\Projects\Seeder;

use Application\Modules\Core\Projects\Projects_Actions;
use Application\Modules\System\Projects\Projects_Model;
use Illuminate\Database\Seeder;

class Projects_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Projects');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Projects_Model::insert($record);
        }
    }
}

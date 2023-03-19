<?php

namespace Application\Modules\Core\Modules\_Modules\ModuleTypes\Seeder;

use Application\Modules\Core\Modules\_Modules\ModuleTypes\ModuleTypes_Model;
use Illuminate\Database\Seeder;

class ModuleTypes_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Modules/_Modules/ModuleTypes');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            ModuleTypes_Model::create($record);
        }
    }
}

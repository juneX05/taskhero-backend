<?php

namespace Application\Modules\System\Projects\_Modules\ProjectCategories\Seeder;

use Application\Modules\System\Projects\_Modules\ProjectCategories\ProjectCategories_Model;
use Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus_Model;
use Illuminate\Database\Seeder;

class ProjectCategories_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Projects/_Modules/ProjectCategories');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']); //special case :)

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            ProjectCategories_Model::create($record);
        }
    }
}

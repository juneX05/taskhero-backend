<?php

namespace Application\Modules\System\Projects\_Modules\ProjectAssignees\Seeder;

use Application\Modules\System\Projects\_Modules\ProjectAssignees\ProjectAssignees_Model;
use Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus_Model;
use Illuminate\Database\Seeder;

class ProjectAssignees_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Projects/_Modules/ProjectAssignees');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']); //special case :)

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            ProjectAssignees_Model::create($record);
        }
    }
}

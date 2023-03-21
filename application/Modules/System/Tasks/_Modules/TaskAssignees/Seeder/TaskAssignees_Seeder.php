<?php

namespace Application\Modules\System\Tasks\_Modules\TaskAssignees\Seeder;

use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees_Model;
use Illuminate\Database\Seeder;

class TaskAssignees_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData(TaskAssignees::PATH);

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            TaskAssignees_Model::create($record);
        }
    }
}

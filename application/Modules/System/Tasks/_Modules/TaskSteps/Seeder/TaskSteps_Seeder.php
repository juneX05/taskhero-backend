<?php

namespace Application\Modules\System\Tasks\_Modules\TaskSteps\Seeder;

use Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps;
use Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps_Model;
use Illuminate\Database\Seeder;

class TaskSteps_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData(TaskSteps::PATH);

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            TaskSteps_Model::create($record);
        }
    }
}

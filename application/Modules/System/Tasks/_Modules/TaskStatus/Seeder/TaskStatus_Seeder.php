<?php

namespace Application\Modules\System\Tasks\_Modules\TaskStatus\Seeder;

use Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus_Model;
use Illuminate\Database\Seeder;

class TaskStatus_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Tasks/_Modules/TaskStatus');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']); //special case :)

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            TaskStatus_Model::create($record);
        }
    }
}

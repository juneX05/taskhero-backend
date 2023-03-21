<?php

namespace Application\Modules\System\Tasks\_Modules\TaskTags\Seeder;

use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags_Model;
use Illuminate\Database\Seeder;

class TaskTags_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData(TaskTags::PATH);

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            TaskTags_Model::create($record);
        }
    }
}

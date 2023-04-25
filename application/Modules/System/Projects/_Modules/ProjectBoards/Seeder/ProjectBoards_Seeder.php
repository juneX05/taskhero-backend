<?php

namespace Application\Modules\System\Projects\_Modules\ProjectBoards\Seeder;

use Application\Modules\System\Projects\_Modules\ProjectBoards\ProjectBoards;
use Application\Modules\System\Projects\_Modules\ProjectBoards\ProjectBoards_Model;
use Application\Modules\System\Projects\_Modules\ProjectPositions\ProjectPositions_Model;
use Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus_Model;
use Illuminate\Database\Seeder;

class ProjectBoards_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData(ProjectBoards::PATH);

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']); //special case :)

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            ProjectBoards_Model::create($record);
        }
    }
}

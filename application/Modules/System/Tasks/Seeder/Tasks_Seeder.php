<?php

namespace Application\Modules\System\Tasks\Seeder;

use Application\Modules\Core\Notifiers\Notifiers_Model;
use Application\Modules\System\Tasks\Tasks_Model;
use Illuminate\Database\Seeder;

class Tasks_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Tasks');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Tasks_Model::create($record);
        }
    }
}

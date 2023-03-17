<?php

namespace Application\Modules\Core\Notifiers\_Modules\SentStatus\Seeder;

use Application\Modules\Core\Notifiers\_Modules\SentStatus\NotifierTypes_Model;
use Application\Modules\Core\Notifiers\_Modules\SentStatus\SentStatus_Model;
use Illuminate\Database\Seeder;

class SentStatus_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Notifiers/_Modules/SentStatus');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            SentStatus_Model::create($record);
        }
    }
}

<?php

namespace Application\Modules\Core\Notifiers\Seeder;

use Application\Modules\Core\Notifiers\Notifiers_Model;
use Illuminate\Database\Seeder;

class Notifiers_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Notifiers');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Notifiers_Model::create($record);
        }
    }
}

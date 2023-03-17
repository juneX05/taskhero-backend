<?php

namespace Application\Modules\Core\Media\Seeder;

use Application\Modules\Core\Media\Media_Model;
use Illuminate\Database\Seeder;

class Media_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Media');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Media_Model::create($record);
        }
    }
}

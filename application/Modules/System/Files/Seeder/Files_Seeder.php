<?php

namespace Application\Modules\System\Files\Seeder;

use Application\Modules\System\Files\Files;
use Application\Modules\System\Files\Files_Model;
use Illuminate\Database\Seeder;

class Files_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData(Files::PATH);

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Files_Model::create($record);
        }
    }
}

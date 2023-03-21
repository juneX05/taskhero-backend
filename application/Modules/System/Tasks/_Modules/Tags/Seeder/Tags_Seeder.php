<?php

namespace Application\Modules\System\Tasks\_Modules\Tags\Seeder;

use Application\Modules\System\Tasks\_Modules\Tags\Tags;
use Application\Modules\System\Tasks\_Modules\Tags\Tags_Model;
use Illuminate\Database\Seeder;

class Tags_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData(Tags::PATH);

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            Tags_Model::create($record);
        }
    }
}

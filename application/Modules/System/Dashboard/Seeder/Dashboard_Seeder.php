<?php

namespace Application\Modules\System\Dashboard\Seeder;

// use Application\Modules\Core\Status\Status_Model;
use Illuminate\Database\Seeder;

class Dashboard_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('Dashboard');

        seedModule($seeder_data['module']);
        seedPermissions($seeder_data['permissions']);
//         $this->seedData($seeder_data['data']);
    }

    // private function seedData($records) {
    //     foreach ($records as $record) {
    //         Status_Model::create($record);
    //     }
    // }
}

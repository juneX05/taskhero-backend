<?php

namespace Application\Modules\Core\Notifiers\_Modules\NotifierTypes\Seeder;

use Application\Modules\Core\Notifiers\_Modules\NotifierTypes\NotifierTypes_Model;
use Illuminate\Database\Seeder;

class NotifierTypes_Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_data = getSeederData('NotifierTypes');

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            NotifierTypes_Model::create($record);
        }
    }
}

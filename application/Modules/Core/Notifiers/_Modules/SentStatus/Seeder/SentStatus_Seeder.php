<?php

namespace Application\Modules\Core\Notifiers\_Modules\SentStatus\Seeder;

use Application\Modules\Core\Notifiers\_Modules\SentStatus\NotifierTypes_Model;
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
        $seeder_data = getSeederData('SentStatus');

        $this->seedData($seeder_data['data']);
    }

    private function seedData($records) {
        foreach ($records as $record) {
            NotifierTypes_Model::create($record);
        }
    }
}

<?php

namespace Application\Modules;

use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $modules = getModules();
        $core_modules = $modules['core_modules'];
        $system_modules = $modules['system_modules'];

        $core_seeders = $this->prepareCoreSeeders($core_modules);
        $system_seeders = $this->prepareSystemSeeders($system_modules);

        $this->call(array_merge($core_seeders, $system_seeders));
    }

    private function prepareCoreSeeders($modules) {
        $ignore = ['Auth'];
        $seeders = [];
        foreach ($modules as $module) {
            if (in_array($module, $ignore)) continue;
            if (file_exists(core_modules_path() .  "/{$module}/Seeder/{$module}_Seeder.php"))
                $seeders[] = "Application\Modules\Core\\{$module}\Seeder\\{$module}_Seeder";
        }
        return $seeders;
    }

    private function prepareSystemSeeders($modules) {
        $seeders = [];
        foreach ($modules as $module) {
            if (file_exists(system_modules_path() .  "/{$module}/Seeder/{$module}_Seeder.php"))
                $seeders[] = "Application\Modules\System\\{$module}\Seeder\\{$module}_Seeder";
        }
        return $seeders;
    }
}

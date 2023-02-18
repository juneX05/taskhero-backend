<?php

namespace Application\Modules;

use Application\ApplicationBootstrapper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SystemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->prepareSeeders();
    }

    private function prepareSeeders() {
        $directories = ApplicationBootstrapper::getApplicationModules();

        $seeders = [];
        foreach ($directories as $index => $module_directories) {
            if ($index == 'core_modules') {
                $parent_directory = core_modules_path() . DIRECTORY_SEPARATOR;
                $parent_namespace =  "Application\Modules\Core";
            }
            else {
                $parent_directory = system_modules_path() . DIRECTORY_SEPARATOR;
                $parent_namespace =  "Application\Modules\System";
            }
            $parent = [
                'directory' => $parent_directory,
                'namespace' => $parent_namespace,
            ];
            $module_seeders = $this->loadSeeders($parent, $module_directories);

            $seeders = array_merge($seeders, $module_seeders);
        }

        $this->call($seeders);
    }

    private function loadSeeders($parent, $module_directories) {

        foreach($module_directories as $module_directory) {
            $module = $this->getModuleName($parent['directory'], $module_directory);

            if (file_exists("{$module_directory}/Seeder/{$module}_Seeder.php"))
                $seeders[] = str_replace('\\\\','\\',$parent['namespace'] . "\\{$module}\Seeder\\{$module}_Seeder");

            if (is_dir($module_directory . "/_Modules")) {
                $module_parent = [
                    'directory' => $module_directory . "/_Modules" . DIRECTORY_SEPARATOR,
                    'namespace' => str_replace('\\\\','\\',$parent['namespace'] . "\\{$module}\_Modules")
                ];
        
                $directories = File::directories($module_directory. "/_Modules");

                $seeders = array_merge_recursive($seeders ?? [], $this->loadSeeders($module_parent, $directories));
            }
        }

        return $seeders ?? [];

    }

    function getModuleName($replace_key, $path) {
        return str_replace($replace_key, '',$path);

    }
}

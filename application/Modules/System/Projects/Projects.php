<?php

namespace Application\Modules\System\Projects;

use Application\Modules\Core\Logs\Jobs\LogActivity;
use Application\Modules\Core\Logs\Logs;
use Illuminate\Database\Query\Builder;

class Projects
{
    const ACTOR = 'Projects';
    const TABLE = 'projects';
    const PATH = 'Projects';

    const COLUMNS = [
        ['name' => 'id', 'type' => 'integer', 'auto_increment' => true, ],
        ['name' => 'title', 'type' => 'string', 'fillable' => true,],
        ['name' => 'description', 'type' => 'long_text', 'fillable' => true,],
        ['name' => 'priority_id', 'type' => 'integer', 'fillable' => true,],
        ['name' => 'media_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'project_category_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'start_date', 'type' => 'date', 'fillable' => true, 'nullable' => true],
        ['name' => 'end_date', 'type' => 'date', 'fillable' => true, 'nullable' => true],
    ];

    private static function relations() {
        return [
            'priority' => function ($query) {
                $query->select(['urid','title']);
            }
            ,'category' => function ($query) {
                $query->select(['urid','title']);
            }
            ,'assignees' => function ($query) {
                $query->select(['name']);
            }
            ,'media' => function ($query) {
                $query->select(['urid','original_name']);
            }
        ];
    }

    public static function getRecord($urid) {
        return Projects_Model
            ::whereUrid($urid)
            ->with(self::relations())->first();
    }

}

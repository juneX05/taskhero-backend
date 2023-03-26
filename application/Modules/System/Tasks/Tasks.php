<?php

namespace Application\Modules\System\Tasks;

use Application\Modules\Core\Logs\Jobs\LogActivity;
use Application\Modules\Core\Logs\Logs;
use Illuminate\Database\Query\Builder;

class Tasks
{
    const TABLE = 'tasks';
    const PATH = 'Tasks';

    const COLUMNS = [
        ['name' => 'id', 'type' => 'integer', 'auto_increment' => true, ],
        ['name' => 'title', 'type' => 'string', 'fillable' => true,],
        ['name' => 'description', 'type' => 'long_text', 'fillable' => true,],
        ['name' => 'priority_id', 'type' => 'integer', 'fillable' => true,],
        ['name' => 'project_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'start_date', 'type' => 'date', 'fillable' => true, 'nullable' => true],
        ['name' => 'end_date', 'type' => 'date', 'fillable' => true, 'nullable' => true],
        ['name' => 'task_status_id', 'type' => 'integer', 'fillable' => true, 'default' => 2],
    ];

    private static function relations() {
        return [
            'priority' => function ($query) {
                $query->select(['urid','title']);
            }
            ,'project' => function ($query) {
                $query->select(['urid','title']);
            }
            ,'status' => function ($query) {
                $query->select(['id','task_status.title']);
            }
            ,'assignees' => function ($query) {
                $query->select(['name']);
            }
            ,'tags' => function ($query) {
                $query->select(['tags.title']);
            }
        ];
    }

    public static function getRecord($urid) {
        return Tasks_Model
            ::whereUrid($urid)
            ->with(self::relations())->first();
    }

}

<?php

namespace Application\Modules\System\Tasks\_Modules\TaskSteps;

use Application\Modules\Core\Status\Status;
use Application\Modules\System\Tasks\_Modules\Tags\Tags_Model;
use Application\Modules\System\Tasks\Tasks_Model;

class TaskSteps
{
    const TABLE = 'task_steps';
    const PATH = 'Tasks/_Modules/TaskSteps';

    const COLUMNS = [
        [
            'name' => 'id',
            'type' => 'integer',
            'primary_key' => true,
            'auto_increment' => true,
        ],
        [
            'name' => 'task_id',
            'type' => 'integer',
            'fillable' => true,
        ],
        [
            'name' => 'title',
            'type' => 'string',
            'fillable' => true,
        ],
        [
            'name' => 'description',
            'type' => 'long_text',
            'fillable' => true,
        ],
        [
            'name' => 'completed',
            'type' => 'integer',
            'fillable' => true,
            'nullable' => true,
            'default' => 0,
        ],
        [
            'name' => 'completed_at',
            'type' => 'date_time',
            'fillable' => true,
            'nullable' => true,
        ],
    ];

    private static function relations() {
        return [
            'steps' => function ($query) {
                $query->select(['steps.title']);
            }
        ];
    }

    public static function getRecord($task_urid, $urid) {
        return TaskSteps_Model
            ::whereUrid($urid)
            ->with('files')
            ->whereTaskId($task_urid)
            ->first();
    }

    public static function getTaskStepRecord($task_urid, $urid) {
        $step = TaskSteps_Model
            ::with(['files' => function ($query) { $query->pluck('original_name'); }])
            ->whereUrid($urid)
            ->whereTaskId($task_urid)
            ->first();
        return ['urid' => $task_urid, 'step' => $step->toArray()];
    }
}

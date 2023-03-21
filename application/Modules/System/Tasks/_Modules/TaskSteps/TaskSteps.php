<?php

namespace Application\Modules\System\Tasks\_Modules\TaskSteps;

use Application\Modules\Core\Status\Status;
use Application\Modules\System\Tasks\_Modules\Tags\Tags_Model;

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

}

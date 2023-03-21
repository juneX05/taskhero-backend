<?php

namespace Application\Modules\System\Tasks\_Modules\TaskStatus;

class TaskStatus
{
    const COMPLETED = 1;
    const PENDING = 2;
    const NEW = 3;
    const OVERDUE = 4;

    const TABLE = 'task_status';
    const PATH = 'Tasks/_Modules/TaskStatus';

    const COLUMNS = [
        [
            'name' => 'id',
            'type' => 'integer',
            'primary_key' => true,
            'auto_increment' => false,
            'nullable' => false,
            'fillable' => true,
        ],
        [
            'name' => 'name',
            'type' => 'string',
            'nullable' => false,
            'unique' => true,
            'fillable' => true,
        ],
        [
            'name' => 'title',
            'type' => 'string',
            'nullable' => false,
            'unique' => true,
            'fillable' => true,
        ],
        [
            'name' => 'color',
            'type' => 'string',
            'nullable' => false,
            'fillable' => true,
        ],
    ];

}

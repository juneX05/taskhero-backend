<?php

namespace Application\Modules\System\Tasks;

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

}

<?php

namespace Application\Modules\System\Files;

class Files
{
    const TABLE = 'files';
    const PATH = 'Files';

    const COLUMNS = [
        ['name' => 'id', 'type' => 'integer', 'auto_increment' => true, ],
        ['name' => 'project_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'task_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'step_id', 'type' => 'integer', 'fillable' => true, 'nullable' => true],
        ['name' => 'media_id', 'type' => 'integer', 'fillable' => true, 'nullable' => false],
    ];

}

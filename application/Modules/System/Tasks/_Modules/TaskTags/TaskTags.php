<?php

namespace Application\Modules\System\Tasks\_Modules\TaskTags;

use Application\Modules\Core\Status\Status;
use Application\Modules\System\Tasks\_Modules\Tags\Tags_Model;

class TaskTags
{
    const TABLE = 'task_tags';
    const PATH = 'Tasks/_Modules/TaskTags';

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
            'name' => 'tag_id',
            'type' => 'integer',
            'fillable' => true,
        ],
    ];

    public static function addTags($task_id, $tags) {
        $items = Tags_Model::whereIn('urid', explode(",",$tags))->pluck('id');
        foreach ($items as $item) {
            $data = [
                'task_id' => $task_id,
                'user_id' => $item,
                'status_id' => Status::ACTIVE
            ];

            $result = TaskTags_Model::create($data);
            if (!$result) return [
                'status' => false,
                'error' => "Failed to add tag ${$data['task_id']} to task"
            ];
        }

        return ['status' => true];
    }

}

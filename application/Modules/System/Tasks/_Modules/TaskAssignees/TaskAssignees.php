<?php

namespace Application\Modules\System\Tasks\_Modules\TaskAssignees;

use Application\Modules\Core\Status\Status;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Projects\_Modules\ProjectPositions\ProjectPositions;

class TaskAssignees
{
    const TABLE = 'task_assignees';
    const PATH = 'Tasks/_Modules/TaskAssignees';

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
            'name' => 'task_id',
            'type' => 'integer',
            'nullable' => false,
            'fillable' => true,
        ],
        [
            'name' => 'user_id',
            'type' => 'integer',
            'nullable' => false,
            'fillable' => true,
        ],
        [
            'name' => 'status_id',
            'type' => 'integer',
            'nullable' => false,
            'fillable' => true,
            'default' => 1
        ],
    ];

    public static function addUsers($task_id, $users) {
        $users = Users_Model::whereIn('urid', explode(",",$users))->pluck('id');
        foreach ($users as $user) {
            $data = [
                'task_id' => $task_id,
                'user_id' => $user,
                'status_id' => Status::ACTIVE
            ];

            $result = TaskAssignees_Model::create($data);
            if (!$result) return [
                'status' => false,
                'error' => "Failed to add user ${$data['user_id']} to project"
            ];
        }

        return ['status' => true];
    }
}

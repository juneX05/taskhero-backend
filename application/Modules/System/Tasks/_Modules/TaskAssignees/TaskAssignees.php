<?php

namespace Application\Modules\System\Tasks\_Modules\TaskAssignees;

use Application\Modules\Core\Logs\Logs;
use Application\Modules\Core\Status\Status;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Projects\_Modules\ProjectPositions\ProjectPositions;
use Application\Modules\System\Tasks\Tasks;
use Application\Modules\System\Tasks\Tasks_Model;
use Illuminate\Console\View\Components\Task;

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

    public static function manageUsers($task, $users) {
        self::removeOldUsers($task);

        $users_ids = self::getNewUsers($users);

        $result = self::processNewUsers($users_ids, $task->id);
        if(!$result['status']) return $result;

        return ['status' => true];
    }

    private static function processNewUsers($user_ids, $task_id) {
        foreach ($user_ids as $user) {
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

    private static function removeOldUsers($task) {
        $old_assigned_users = $task->assignees()->get(['users.name'])->pluck('name');
        TaskAssignees_Model
            ::where('task_id',$task->id)
            ->delete();

        return $old_assigned_users;
    }

    private static function getNewUsers($users) {
        $new_users = gettype($users) == 'string'
            ? explode(",",$users)
            : $users;
        return Users_Model::whereIn('urid', $new_users)
            ->pluck('id');
    }

}

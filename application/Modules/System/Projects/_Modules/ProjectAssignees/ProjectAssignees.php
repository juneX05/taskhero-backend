<?php

namespace Application\Modules\System\Projects\_Modules\ProjectAssignees;

use Application\Modules\Core\Status\Status;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Projects\_Modules\ProjectPositions\ProjectPositions;

class ProjectAssignees
{

    public static function manageUsers($project, $users) {
        self::removeOldUsers($project);

        $users_ids = self::getNewUsers($users);

        $result = self::processNewUsers($users_ids, $project->id);
        if(!$result['status']) return $result;

        return ['status' => true];
    }

    private static function processNewUsers($user_ids, $project_id) {
        foreach ($user_ids as $user) {
            $data = [
                'project_id' => $project_id,
                'user_id' => $user,
                'status_id' => Status::ACTIVE,
                'project_position_id' => ProjectPositions::MEMBER
            ];

            $result = ProjectAssignees_Model::create($data);
            if (!$result) return [
                'status' => false,
                'error' => "Failed to add user ${$data['user_id']} to project"
            ];
        }

        return ['status' => true];
    }

    private static function removeOldUsers($project) {
        $old_assigned_users = $project->assignees()->get(['users.name'])->pluck('name');
        ProjectAssignees_Model
            ::where('project_id',$project->id)
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

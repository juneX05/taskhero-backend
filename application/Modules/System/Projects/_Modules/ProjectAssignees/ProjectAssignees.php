<?php

namespace Application\Modules\System\Projects\_Modules\ProjectAssignees;

use Application\Modules\Core\Status\Status;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Projects\_Modules\ProjectPositions\ProjectPositions;

class ProjectAssignees
{
    public static function addUsers($project_id, $users) {
        $users = Users_Model::whereIn('urid', explode(",",$users))->pluck('id');
        foreach ($users as $user) {
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
}

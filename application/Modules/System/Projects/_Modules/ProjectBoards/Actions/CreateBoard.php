<?php

namespace Application\Modules\System\Projects\_Modules\ProjectBoards\Actions;

use Application\Modules\Core\Logs\Logs;
use Application\Modules\System\Files\Files;
use Application\Modules\System\Projects\_Modules\ProjectBoards\ProjectBoards;
use Application\Modules\System\Projects\_Modules\ProjectBoards\ProjectBoards_Model;
use Application\Modules\System\Projects\Projects;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps;
use Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps_Model;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Application\Modules\System\Tasks\Tasks;
use Application\Modules\System\Tasks\Tasks_Model;

class CreateBoard
{
    public static function boot($request_data, $project_urid) {

        $project = Projects::getRecord($project_urid);
        if (!$project) return error('Project not found');

        //validate request data
        $validation = self::validateData($request_data);
        if (!$validation['status']) return error($validation);

        //get validated data
        $data = $validation['data'];

        \DB::beginTransaction();

        $data['project_id'] = $project_urid;
        //save or create new board
        $result = self::save($data);
        if (!$result['status']) return error('Failed to create board.');

        $record = $result['data'];

        \DB::commit();

        $new_record = ProjectBoards::getRecord($record->urid)->toArray();
        Logs::saveLog('Create Board', 'created', $new_record);
        //send response back to user
        return success(
            message: 'Board Created Successfully',
            data: $new_record
        );
    }

    private static function validateData($request_data) {
        return validateData($request_data,[
            'title' => ['required', ],
            'description' => ['required'],
        ]);
    }

    private static function save($data) {
        $model = ProjectBoards_Model::create($data);

        if(!$model) {
            return error('Failed to save board');
        }

        return success(data: $model);
    }
}

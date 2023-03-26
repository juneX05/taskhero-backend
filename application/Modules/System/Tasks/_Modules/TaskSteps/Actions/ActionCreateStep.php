<?php

namespace Application\Modules\System\Tasks\_Modules\TaskSteps\Actions;

use Application\Modules\Core\Logs\Logs;
use Application\Modules\System\Files\Files;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps;
use Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps_Model;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Application\Modules\System\Tasks\Tasks;
use Application\Modules\System\Tasks\Tasks_Model;

class ActionCreateStep
{
    public static function boot($request_data, $task_urid) {
        //check user permission
        if (denied('view_task')) return sendErrorResponse('Forbidden');

        $task = Tasks::getRecord($task_urid);
        if (!$task) return sendErrorResponse('Task not found');

        //validate request data
        $validation = self::validateData($request_data);
        if (!$validation['status']) return sendErrorResponse($validation);

        //get validated data
        $data = $validation['data'];

        \DB::beginTransaction();

        $data['task_id'] = $task_urid;
        //save or create new task
        $result = self::saveStep($data);
        if (!$result['status']) return sendErrorResponse('Failed to create step.');

        $record = $result['data'];

        //assign users to task
        if (isset($data['files'])) {
            foreach ($data['files'] as $file) {
                $result = Files::saveFile($file, 'step_id', $record->id);
                if (!$result['status']) return sendErrorResponse($result['error']);
            }
        }

        \DB::commit();

        $new_record = TaskSteps::getTaskStepRecord($task_urid, $record->urid);
        Logs::$ACTOR='Tasks';
        Logs::saveLog('Create Step', 'created', $new_record);

        //send response back to user
        return sendResponse('Step Created Successfully');
    }

    private static function validateData($request_data) {
        return validateData($request_data,[
            'title' => ['required', ],
            'description' => ['required'],
            'files' => ['nullable'],
        ]);
    }

    private static function saveStep($data) {
        $model = TaskSteps_Model::create($data);

        if(!$model) {
            return ['status' => false, 'message' => 'Failed to save Step'];
        }

        return ['status' => true, 'data' => $model];
    }
}

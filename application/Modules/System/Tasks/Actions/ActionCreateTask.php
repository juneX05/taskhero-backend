<?php

namespace Application\Modules\System\Tasks\Actions;

use Application\Modules\Core\Logs\Jobs\LogActivity;
use Application\Modules\Core\Logs\Logs;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Application\Modules\System\Tasks\Tasks;
use Application\Modules\System\Tasks\Tasks_Model;
use Illuminate\Validation\Rule;

class ActionCreateTask
{
    public static function boot($request_data) {
        //check user permission
        if (denied('create_task')) return sendErrorResponse('Forbidden');

        //validate request data
        $validation = self::validateData($request_data);
        if (!$validation['status']) return sendErrorResponse($validation);

        //get validated data
        $data = $validation['data'];

        \DB::beginTransaction();

        //save or create new task
        $result = self::saveTask($data);
        if (!$result['status']) return sendErrorResponse('Failed to create task.');

        $record = $result['data'];

        //assign users to task
        if (isset($data['assigned'])) {
            $assigning_result = TaskAssignees::manageUsers($record,$data['assigned']);
            if (!$assigning_result['status']) return sendErrorResponse($assigning_result);
        }

        //assign tags to task
        if (isset($data['task_tags'])) {
            $tags_result = TaskTags::manageTags($record,$data['task_tags']);
            if (!$tags_result['status']) return sendErrorResponse($tags_result);
        }

        \DB::commit();

        $new_record = Tasks::getRecord($record->urid)->toArray();
        Logs::saveLog('Create Task', 'created', $new_record);

        //send response back to user
        return sendResponse('Task Created Successfully');
    }

    private static function validateData($request_data) {
        return validateData($request_data,[
            'title' => ['required', ],
            'description' => ['required'],
            'priority_id' => ['required'],
            'project_id' => ['nullable'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'assigned' => ['required'],
            'task_tags' => ['nullable'],
        ]);
    }

    private static function saveTask($data) {
        $model = Tasks_Model::create($data);

        if(!$model) {
            return ['status' => false, 'message' => 'Failed to save Task'];
        }

        return ['status' => true, 'data' => $model];
    }
}

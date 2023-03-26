<?php

namespace Application\Modules\System\Tasks\Actions;

use Application\Modules\Core\Logs\Logs;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Application\Modules\System\Tasks\Tasks;
use Application\Modules\System\Tasks\Tasks_Model;
use Illuminate\Validation\Rule;

class ActionUpdateTask
{
    public static function boot($request_data, $urid) {
        //check user permission
        if (denied('update_task')) return sendErrorResponse('Forbidden');

        //check task validity
        $record = Tasks::getRecord($urid);
        $old_record = $record->toArray();

        if (!$old_record) return sendErrorResponse('Task not Found');

        //validate request data
        $validation = self::validateData($request_data, $record);
        if (!$validation['status']) return sendErrorResponse($validation);

        //get validated data
        $data = $validation['data'];

        \DB::beginTransaction();

        //update new task
        $update = $record->update($data);
        if (!$update) return sendErrorResponse('Failed to update task.');

        //update assign users to task
        if (isset($data['assigned'])) {
            $assigning_result = TaskAssignees::manageUsers($record,$data['assigned']);
            if (!$assigning_result['status']) return sendErrorResponse($assigning_result);
        }

        //update assign tags to task
        if (isset($data['task_tags'])) {
            $tags_result = TaskTags::manageTags($record,$data['task_tags']);
            if (!$tags_result['status']) return sendErrorResponse($tags_result);
        }

        \DB::commit();

        //prepare log data

        $new_record = Tasks::getRecord($record->urid);
        Logs::saveLog('Update Task', 'updated', $new_record, $old_record);

        //send response back to user
        return sendResponse('Task Updated Successfully');
    }

    private static function validateData($request_data, Tasks_Model $model) {
        return validateData($request_data,[
            'title' => ['required', Rule::unique(Tasks::TABLE)->ignore($model->id)],
            'description' => ['required'],
            'priority_id' => ['required'],
            'project_id' => ['nullable'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'assigned' => ['required'],
            'task_tags' => ['nullable'],
        ]);
    }
}

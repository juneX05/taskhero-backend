<?php

namespace Application\Modules\System\Tasks\Actions;

use Application\Modules\Core\Logs\Logs;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Application\Modules\System\Tasks\Tasks;
use Application\Modules\System\Tasks\Tasks_Model;
use Illuminate\Validation\Rule;

class ActionCompleteTask
{
    public static function boot($request_data, $urid) {
        //check user permission
        if (denied('complete_task')) return sendErrorResponse('Forbidden');

        //check task validity
        $record = Tasks::getRecord($urid);
        $old_record = $record->toArray();

        if (!$old_record) return sendErrorResponse('Task not Found');

        //validate request data
        $validation = self::validateData($request_data, $record);
        if (!$validation['status']) return sendErrorResponse($validation);

        //get validated data
        $data = $validation['data'];
        $data['task_status_id'] = TaskStatus::COMPLETED;

        \DB::beginTransaction();

        //update new task
        $update = $record->update($data);
        if (!$update) return sendErrorResponse('Failed to complete task.');

        \DB::commit();

        //prepare log data
        $new_record = Tasks::getRecord($record->urid);
        Logs::saveLog('Complete Task', 'updated', $new_record, $old_record);

        //send response back to user
        return sendResponse('Task Completed Successfully');
    }

    private static function validateData($request_data, Tasks_Model $model) {
        return validateData($request_data,[
            'notes' => ['required'],
        ]);
    }
}

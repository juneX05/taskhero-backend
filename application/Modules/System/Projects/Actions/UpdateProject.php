<?php

namespace Application\Modules\System\Projects\Actions;

use Application\Modules\Core\Logs\Logs;
use Application\Modules\Core\Media\Media;
use Application\Modules\System\Projects\_Modules\ProjectAssignees\ProjectAssignees;
use Application\Modules\System\Projects\Projects;
use Application\Modules\System\Projects\Projects_Model;

class UpdateProject
{
    public static function boot($request_data, $urid) {
        //check user permission
        if (denied('update_project')) return sendErrorResponse('Forbidden');

        //check task validity
        $record = Projects::getRecord($urid);
        $old_record = $record->toArray();

        if (!$old_record) return sendErrorResponse('Record not Found');

        //validate request data
        $validation = self::validateData($request_data, $record);
        if (!$validation['status']) return sendErrorResponse($validation);

        //get validated data
        $data = $validation['data'];

        \DB::beginTransaction();

        //update record
        if (isset($data['image'])){
            $file = Media::saveFile($data['image']);
            if (!$file['status']) return sendError('Failed to save project image', 500);

            $data['media_id'] = $file['id'];
        }

        $update = $record->update($data);
        if (!$update) return sendErrorResponse('Failed to update project.');

        //assign users to project
        $result = ProjectAssignees::manageUsers($record,$data['assigned']);

        if (!$result['status']) {
            return $result;
        }

        \DB::commit();

        //prepare log data
        $new_record = Projects::getRecord($record->urid)->toArray();
        Logs::saveLog('Update Project', 'updated', $new_record, $old_record);

        //send response back to user
        return sendResponse('Record Updated Successfully');
    }

    private static function validateData($request_data, Projects_Model $model) {
        return validateData($request_data,[
            'title' => ['required'],
            'description' => ['required'],
            'priority_id' => ['required'],
            'project_category_id' => ['required'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'assigned' => ['required'],
            'image' => ['nullable','file'],
        ]);
    }
}

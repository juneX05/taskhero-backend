<?php

namespace Application\Modules\System\Projects\Actions;

use Application\Modules\Core\Logs\Jobs\LogActivity;
use Application\Modules\Core\Logs\Logs;
use Application\Modules\Core\Media\Media;
use Application\Modules\System\Projects\_Modules\ProjectAssignees\ProjectAssignees;
use Application\Modules\System\Projects\Projects;
use Application\Modules\System\Projects\Projects_Model;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Application\Modules\System\Tasks\Tasks;
use Application\Modules\System\Tasks\Tasks_Model;
use Illuminate\Validation\Rule;

class CreateProject
{
    public static function boot($request_data) {
        //check user permission
        if (denied('create_project')) return sendErrorResponse('Forbidden');

        //validate request data
        $validation = self::validateData($request_data);
        if (!$validation['status']) return sendErrorResponse($validation);

        //get validated data
        $data = $validation['data'];

        \DB::beginTransaction();

        $file = Media::saveFile($data['image']);
        if (!$file['status']) return sendError('Failed to save project image', 500);

        $data['media_id'] = $file['id'];

        $result = self::save($data);
        if (!$result['status']) return sendErrorResponse('Failed to create record.');

        $record = $result['data'];

        //assign users to project
        $result = ProjectAssignees::manageUsers($record,$data['assigned']);

        if (!$result['status']) {
            return $result;
        }

        \DB::commit();

        $new_record = Projects::getRecord($record->urid)->toArray();
        Logs::saveLog(Projects::ACTOR,'Create Project', 'created', $new_record);

        //send response back to user
        return sendResponse('Record Created Successfully');
    }

    private static function validateData($request_data) {
        return validateData($request_data,[
            'title' => ['required'],
            'description' => ['required'],
            'priority_id' => ['required'],
            'project_category_id' => ['required'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'assigned' => ['required'],
            'image' => ['required','file'],
        ]);
    }

    private static function save($data) {
        $model = Projects_Model::create($data);

        if(!$model) {
            return ['status' => false, 'message' => 'Failed to save record'];
        }

        return ['status' => true, 'data' => $model];
    }
}

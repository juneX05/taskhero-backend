<?php


namespace Application\Modules\System\Tasks;

use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Priorities\Priorities_Model;
use Application\Modules\System\Projects\Projects_Model;
use Application\Modules\System\Tasks\_Modules\Tags\Tags_Model;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees_Model;
use Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Tasks_Actions

{
    private static $ACTOR = 'Tasks';
    private static $TABLE = Tasks::TABLE;

    public static function index() {
        if (denied('view_tasks')) return sendError('Forbidden', 403);
        try {
            $all_data = Tasks_Model::with(['assignees', 'priority'])->get();

            return sendResponse('Success', $all_data);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function myTasks() {
        if (denied('view_tasks')) return sendError('Forbidden', 403);
        try {
            $user = Users_Model::with(['tasks.assignees', 'tasks.priority'])
                ->find(\Auth::id());
            $all_data = $user->tasks;

            return sendResponse('Success', $all_data);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function splash() {
        if (denied('view_tasks')) return sendError('Forbidden', 403);

        try {
            $data = [];
            $data['priorities'] = Priorities_Model::all();
            $data['tags'] = Tags_Model::all();
            $data['users'] = Users_Model::all();
            $data['projects'] = Projects_Model::all();

            return sendResponse('Success', $data);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function saveTask($request_data) {
        if (denied('create_task')) return sendError('Forbidden', 500);

        try {
            $validation = validateData($request_data,[
                'title' => ['required', Rule::unique(self::$TABLE)],
                'description' => ['required'],
                'priority_id' => ['required'],
                'project_id' => ['nullable'],
                'start_date' => ['nullable', 'date'],
                'end_date' => ['nullable', 'date'],
                'assigned' => ['required'],
                'task_tags' => ['nullable','array'],
            ]);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            \DB::beginTransaction();

            $model = Tasks_Model::create($data);

            if(!$model) {
                return sendError('Failed to save record', 500);
            }

            $result = TaskAssignees::manageUsers($model,$data['assigned']);

            if (!$result['status']) {
                return sendError($result['error'], 500);
            }

            if (isset($data['task_tags'])) {
                $result = TaskTags::manageTags($model,$data['task_tags']);
            }

            if (!$result['status']) {
                return sendError($result['error'], 500);
            }

            \DB::commit();

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Task',
                'old_data' => json_encode([]),
                'new_data' => json_encode($model->toArray()),
            ],'SAVE-TASK');

            return sendResponse('Success', $model);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function viewTask($urid) {
        if (denied('view_task')) return sendError('Forbidden', 500);

        try {
            $record = Tasks_Model
                ::whereUrid($urid)
                ->with(['priority','project.media','status','assignees','steps','files.media', 'tags'])
                ->first();
            if (!$record) {
                return sendError('Record Not found', 404);
            }

            return sendResponse('Success', $record);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function updateTask($request_data, $urid) {
        if (denied('create_task')) return sendError('Forbidden', 500);

        try {
            $record = Tasks_Model
                ::whereUrid($urid)
                ->with(['priority','project','status','assignees','steps','files.media', 'tags'])
                ->first();
            if (!$record) {
                return sendError('Record Not found', 404);
            }

            $old_data = $record->toArray();

            $validation = validateData($request_data,[
                'title' => ['required', Rule::unique(self::$TABLE)->ignore($record->id)],
                'description' => ['required'],
                'priority_id' => ['required'],
                'project_id' => ['nullable'],
                'start_date' => ['nullable', 'date'],
                'end_date' => ['nullable', 'date'],
                'assigned' => ['required'],
                'task_tags' => ['nullable','array'],
            ]);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            \DB::beginTransaction();

            $update = $record->update($data);

            if(!$update) {
                return sendError('Failed to update record', 500);
            }

            $result = TaskAssignees::manageUsers($record,$data['assigned']);

            if (!$result['status']) {
                return sendError($result['error'], 500);
            }

            if (isset($data['task_tags'])) {
                $result = TaskTags::manageTags($record,$data['task_tags']);
            }

            if (!$result['status']) {
                return sendError($result['error'], 500);
            }

            \DB::commit();

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update Task',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record->toArray()),
            ],'UPDATE-TASK');

            return sendResponse('Success', $record);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function completeTask($request_data, $urid) {
        if (denied('complete_task')) return sendError('Forbidden', 500);

        return self::changeStatus(
            __FUNCTION__
            ,$urid
            , $request_data
            , TaskStatus::COMPLETED
            , 'Complete Task'
            , 'COMPLETE-TASK'
        );
    }

    public static function reOpenTask($request_data, $urid) {
        if (denied('re_open_task')) return sendError('Forbidden', 500);

        return self::changeStatus(
            __FUNCTION__
            , $urid
            , $request_data
            , TaskStatus::PENDING
            , 'Re-Open Task'
            , 'RE-OPEN-TASK'
        );
    }

    private static function changeStatus($tag, $urid, $request_data, $status, $action_description, $action_type) {
        try {
            $record = Tasks_Model
                ::whereUrid($urid)
                ->with(['priority','project','status','assignees','steps','files.media', 'tags'])
                ->first();
            if (!$record) {
                return sendError('Record Not found', 404);
            }

            $old_data = $record->toArray();

            $validation = validateData($request_data,[
                'notes' => ['required'],
            ]);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            $data['task_status_id'] = $status;

            \DB::beginTransaction();

            $update = $record->update($data);

            if(!$update) {
                return sendError('Failed to update record', 500);
            }

            \DB::commit();

            logInfo($tag,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => $action_description,
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record->toArray()),
            ],$action_type);

            return sendResponse('Success', $record);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }
}

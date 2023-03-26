<?php


namespace Application\Modules\System\Tasks;

use Application\Modules\Core\Logs\Logs;
use Application\Modules\Core\Logs\Logs_Actions;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Priorities\Priorities_Model;
use Application\Modules\System\Projects\Projects_Model;
use Application\Modules\System\Tasks\_Modules\Tags\Tags_Model;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees_Model;
use Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Application\Modules\System\Tasks\Actions\ActionSaveTask;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Tasks_Actions
{

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
}

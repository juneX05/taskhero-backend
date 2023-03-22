<?php
namespace Application\Modules\System\Projects;

use Application\Modules\Core\Media\Media;
use Application\Modules\Core\Media\Media_Actions;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Priorities\Priorities_Model;
use Application\Modules\System\Projects\_Modules\ProjectAssignees\ProjectAssignees;
use Application\Modules\System\Projects\_Modules\ProjectAssignees\ProjectAssignees_Model;
use Application\Modules\System\Projects\_Modules\ProjectCategories\ProjectCategories_Model;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Projects_Actions
{
    private static $ACTOR = 'Projects';

    public static function index() {
        if (denied('view_projects')) return sendError('Forbidden', 403);

        try {
            $projects = Projects_Model
                ::with(['category','priority','assignees', 'media'])
                ->get();

            return sendResponse('Success', $projects);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function splash() {
        if (denied('view_projects')) return sendError('Forbidden', 403);

        try {
            $data = [];
            $data['priorities'] = Priorities_Model::all();
            $data['categories'] = ProjectCategories_Model::all();
            $data['users'] = Users_Model::all();

            return sendResponse('Success', $data);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function saveProject($request_data) {
        if (denied('create_project')) return sendError('Forbidden', 500);

        try {
            $validation = validateData($request_data,[
                'title' => ['required'],
                'description' => ['required'],
                'priority_id' => ['required'],
                'project_category_id' => ['required'],
                'start_date' => ['nullable', 'date'],
                'end_date' => ['nullable', 'date'],
                'assigned' => ['required'],
                'image' => ['required','file'],
            ]);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            \DB::beginTransaction();

            $file = Media::saveFile($data['image']);
            if (!$file['status']) return sendError('Failed to save project image', 500);

            $data['media_id'] = $file['id'];
            $model = Projects_Model::create($data);

            if(!$model) {
                return sendError('Failed to save record', 500);
            }

            $result = ProjectAssignees::addUsers($model->id,$data['assigned']);

            if (!$result['status']) {
                return $result;
            }

            \DB::commit();

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Project',
                'old_data' => json_encode([]),
                'new_data' => json_encode($model->toArray()),
            ],'SAVE-PROJECT');

            return sendResponse('Success', $model);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }
}

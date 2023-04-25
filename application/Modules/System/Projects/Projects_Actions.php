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

}

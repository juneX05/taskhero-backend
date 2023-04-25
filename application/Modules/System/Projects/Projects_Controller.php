<?php

namespace Application\Modules\System\Projects;

use Application\Modules\BaseController;
use Application\Modules\System\Projects\Actions\CreateProject;
use Application\Modules\System\Projects\Actions\GetProjectDetails;
use Application\Modules\System\Projects\Actions\UpdateProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Projects_Controller extends BaseController
{

    public function index()
    {
        return Projects_Actions::index();
    }

    public function splash()
    {
        return Projects_Actions::splash();
    }

    public function save(Request $request)
    {
        return CreateProject::boot($request->all());
    }

    public function view($urid)
    {
        return GetProjectDetails::boot($urid);
    }

    public function update(Request $request, $urid)
    {
        return UpdateProject::boot($request->all(),$urid);
    }

    public function saveBoard(Request $request, $urid)
    {
        return UpdateProject::boot($request->all(),$urid);
    }


}

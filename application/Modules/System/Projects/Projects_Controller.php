<?php

namespace Application\Modules\System\Projects;

use Application\Modules\BaseController;
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
        return Projects_Actions::saveProject($request->all());
    }


}

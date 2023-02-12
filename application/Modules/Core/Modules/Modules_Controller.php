<?php

namespace Application\Modules\Core\Modules;

use Application\Modules\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Modules_Controller extends BaseController
{

    public function index()
    {
        return Modules_Actions::index();
    }

    public function view($module_id)
    {
        return Modules_Actions::viewModule($module_id);
    }

    public function statuses()
    {
        return Modules_Actions::getModuleStatuses();
    }

    public function save(Request $request) {
       return Modules_Actions::saveModule($request->all());
    }

    public function update(Request $request) {
        return Modules_Actions::updateModule($request->all());
    }

    public function changeStatus(Request $request) {
        return Modules_Actions::changeModuleStatus($request->all());
    }
}

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
        $result = Modules_Actions::index();
        return sendResponse($result);
    }

    public function view($module_id)
    {
        $result = Modules_Actions::viewModule($module_id);
        return sendResponse($result);
    }

    public function statuses()
    {
        $result = Modules_Actions::getModuleStatuses();
        return sendResponse($result);
    }

    public function save(Request $request) {
       $result = Modules_Actions::saveModule($request->all());
        return sendResponse($result);
    }

    public function update(Request $request) {
        $result = Modules_Actions::updateModule($request->all());
        return sendResponse($result);
    }

    public function changeStatus(Request $request) {
        $result = Modules_Actions::changeModuleStatus($request->all());
        return sendResponse($result);
    }
}

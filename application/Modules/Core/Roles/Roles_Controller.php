<?php

namespace Application\Modules\Core\Roles;

use Application\Modules\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Roles_Controller extends BaseController
{

    public function index()
    {
        $result = Roles_Actions::index();
        return sendResponse($result);
    }

    public function view($urid)
    {
        $result = Roles_Actions::viewRole($urid);
        return sendResponse($result);
    }

    public function save(Request $request)
    {
        $result = Roles_Actions::saveRole($request->all());
        return sendResponse($result);
    }

    public function update(Request $request, $urid)
    {
        $result = Roles_Actions::updateRole($request->all(), $urid);
        return sendResponse($result);
    }

    public function changePermissions(Request $request, $urid) {
        $result = Roles_Actions::changeRolePermissions($request->all(), $urid);
        return sendResponse($result);
    }

    public function getRoleStatuses() {
        $result = Roles_Actions::getRoleStatuses();
        return sendResponse($result);
    }

    public function activate(Request $request,$urid) {
        $result = Roles_Actions::activateRole($request->all(), $urid);
        return sendResponse($result);
    }

    public function deactivate(Request $request,$urid) {
        $result = Roles_Actions::deactivateRole($request->all(), $urid);
        return sendResponse($result);
    }

    public function getPermissions($urid) {
        $result = Roles_Actions::getRolePermissions($urid);
        return sendResponse($result);
    }

}

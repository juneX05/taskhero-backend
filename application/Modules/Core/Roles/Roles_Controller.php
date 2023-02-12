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
        return Roles_Actions::index();
    }

    public function view($urid)
    {
        return Roles_Actions::viewRole($urid);
    }

    public function save(Request $request)
    {
        return Roles_Actions::saveRole($request->all());
    }

    public function update(Request $request, $urid)
    {
        return Roles_Actions::updateRole($request->all(), $urid);
    }

    public function changePermissions(Request $request, $urid) {
        return Roles_Actions::changeRolePermissions($request->all(), $urid);
    }

    public function getRoleStatuses() {
        return Roles_Actions::getRoleStatuses();
    }

    public function changeStatus(Request $request, $urid) {
        return Roles_Actions::changeRoleStatus($request->all(), $urid);
    }

}

<?php

namespace Application\Modules\Core\Permissions;

use Application\Modules\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Permissions_Controller extends BaseController
{

    public function index(){
        return Permissions_Actions::index();
    }

    public function save(Request $request) {
        return Permissions_Actions::savePermission($request->all());
    }

    public function update(Request $request) {
        return Permissions_Actions::updatePermission($request->all());
    }
}

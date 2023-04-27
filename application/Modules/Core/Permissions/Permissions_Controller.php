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
        $result = Permissions_Actions::index();
        return sendResponse($result);
    }

    public function save(Request $request) {
        $result = Permissions_Actions::savePermission($request->all());
        return sendResponse($result);
    }

    public function update(Request $request) {
        $result = Permissions_Actions::updatePermission($request->all());
        return sendResponse($result);
    }
}

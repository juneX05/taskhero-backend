<?php

namespace Application\Modules\Core\Users;

use Application\Modules\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class Users_Controller extends BaseController {

    public function index() {
        return Users_Actions::index();
    }

    public function view($urid) {
        return Users_Actions::viewUser($urid);
    }

    public function userTypes() {
        return Users_Actions::getUserTypes();
    }

    public function changeUserPassword(Request $request) {
        return Users_Actions::changeUserPassword($request->all());
    }

    public function changePassword(Request $request) {
        return Users_Actions::changePassword($request->all());
    }

    public function changeUserPermissions(Request $request) {
        return Users_Actions::changeUserPermissions($request->all());
    }

    public function changeUserRoles(Request $request) {
        return Users_Actions::changeUserRoles($request->all());
    }

    public function save(Request $request) {
        return Users_Actions::saveUser($request->all());
    }

    public function profile() {
        return Users_Actions::getUserProfile();
    }

}

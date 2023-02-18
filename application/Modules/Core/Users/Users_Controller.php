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

    public function changePermissions(Request $request) {
        return Users_Actions::changeUserPermissions($request->all());
    }

    public function changeRoles(Request $request) {
        return Users_Actions::changeUserRoles($request->all());
    }

    public function save(Request $request) {
        return Users_Actions::saveUser($request->all());
    }

    public function profile() {
        return Users_Actions::getUserProfile();
    }

    public function profileUpdate(Request $request) {
        return Users_Actions::updateUserProfile($request->all());
    }

    public function update(Request $request, $urid) {
        return Users_Actions::update($request->all(), $urid);
    }

    public function completeRegistration(Request $request, $urid) {
        return Users_Actions::completeUserRegistration($request->all(), $urid);
    }

}

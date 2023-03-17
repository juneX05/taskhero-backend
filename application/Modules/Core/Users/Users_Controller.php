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

    public function splash() {
        return Users_Actions::splash();
    }

    public function changeUserPassword(Request $request) {
        return Users_Actions::changeUserPassword($request->all());
    }

    public function changePassword(Request $request) {
        return Users_Actions::changePassword($request->all());
    }

    public function changePermissions(Request $request, $urid) {
        return Users_Actions::changeUserPermissions($request->all(), $urid);
    }

    public function getPermissions($urid) {
        return Users_Actions::getUserPermissions( $urid);
    }

    public function changeRoles(Request $request, $urid) {
        return Users_Actions::changeUserRoles($request->all(), $urid);
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

    public function updateAccountDetails(Request $request, $urid) {
        return Users_Actions::updateUserAccountDetails($request->all(), $urid);
    }

    public function completeRegistration($urid) {
        return Users_Actions::completeUserRegistration($urid);
    }

    public function deactivate(Request $request, $urid) {
        return Users_Actions::deactivateUser($request->all(), $urid);
    }

    public function activate(Request $request, $urid) {
        return Users_Actions::activateUser($request->all(), $urid);
    }

}

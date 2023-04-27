<?php

namespace Application\Modules\Core\Users;

use Application\Modules\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class Users_Controller extends BaseController {

    public function index() {
        $result = Users_Actions::index();
        return sendResponse($result);
    }

    public function view($urid) {
        $result = Users_Actions::viewUser($urid);
        return sendResponse($result);
    }

    public function splash() {
        $result = Users_Actions::splash();
        return sendResponse($result);
    }

    public function changeUserPassword(Request $request) {
        $result = Users_Actions::changeUserPassword($request->all());
        return sendResponse($result);
    }

    public function changePassword(Request $request) {
        $result = Users_Actions::changePassword($request->all());
        return sendResponse($result);
    }

    public function changePermissions(Request $request, $urid) {
        $result = Users_Actions::changeUserPermissions($request->all(), $urid);
        return sendResponse($result);
    }

    public function getPermissions($urid) {
        $result = Users_Actions::getUserPermissions( $urid);
        return sendResponse($result);
    }

    public function changeRoles(Request $request, $urid) {
        $result = Users_Actions::changeUserRoles($request->all(), $urid);
        return sendResponse($result);
    }

    public function save(Request $request) {
        $result = Users_Actions::saveUser($request->all());
        return sendResponse($result);
    }

    public function profile() {
        $result = Users_Actions::getUserProfile();
        return sendResponse($result);
    }

    public function profileUpdate(Request $request) {
        $result = Users_Actions::updateUserProfile($request->all());
        return sendResponse($result);
    }

    public function updateAccountDetails(Request $request, $urid) {
        $result = Users_Actions::updateUserAccountDetails($request->all(), $urid);
        return sendResponse($result);
    }

    public function completeRegistration($urid) {
        $result = Users_Actions::completeUserRegistration($urid);
        return sendResponse($result);
    }

    public function deactivate(Request $request, $urid) {
        $result = Users_Actions::deactivateUser($request->all(), $urid);
        return sendResponse($result);
    }

    public function activate(Request $request, $urid) {
        $result = Users_Actions::activateUser($request->all(), $urid);
        return sendResponse($result);
    }

}

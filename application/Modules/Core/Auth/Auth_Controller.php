<?php


namespace Application\Modules\Core\Auth;


use Application\Modules\Core\Menus\Menus_Actions;
use Application\Modules\Core\Menus\Menus_Model;
use Application\Modules\Core\Roles\_Modules\RolePermissions\RolePermissions_Model;
use Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions_Model;
use Application\Modules\Core\Users\_Modules\UserRoles\UserRoles_Model;
use Application\Modules\Core\Users\Users_Model;
use Illuminate\Http\Request;
use Application\Modules\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Auth_Controller extends BaseController
{

    public function mobileLogin(Request $request) {
        return Auth_Actions::mobileLogin($request->all());
    }

    public function login(Request $request) {
        return Auth_Actions::login($request->all());
    }

    public function logout() {
        return Auth_Actions::logout();
    }

    public function user() {
        return Auth_Actions::currentUser();
    }

    //https://victorighalo.medium.com/custom-password-reset-in-laravel-21e57816989f
    public function forgotPassword(Request $request) {
        return Auth_Actions::forgotPassword($request->all());
    }

    public function resetPassword(Request $request) {
        return Auth_Actions::resetPassword($request->all());
    }

    public function register(Request $request) {
        return Auth_Actions::register($request->all());
    }
}

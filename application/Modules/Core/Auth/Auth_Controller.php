<?php


namespace Application\Modules\Core\Auth;


use Application\Modules\Core\Menus\Menus_Actions;
use Application\Modules\Core\Menus\Menus_Model;
use Application\Modules\Core\RolePermissions\RolePermissions_Model;
use Application\Modules\Core\UserPermissions\UserPermissions_Model;
use Application\Modules\Core\UserRoles\UserRoles_Model;
use Application\Modules\Core\Users\Users_Model;
use Illuminate\Http\Request;
use Application\Modules\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Auth_Controller extends BaseController
{

    public function login(Request $request) {
        return Auth_Actions::login($request->all());
    }

    public function logout() {
        return Auth_Actions::logout();
    }

    public function user() {
        return Auth_Actions::currentUser();
    }
}

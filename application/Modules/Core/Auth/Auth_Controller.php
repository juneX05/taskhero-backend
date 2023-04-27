<?php


namespace Application\Modules\Core\Auth;


use Application\Modules\Core\Auth\Actions\ForgotPassword;
use Application\Modules\Core\Auth\Actions\GetCurrentLoggedInUser;
use Application\Modules\Core\Auth\Actions\Login;
use Application\Modules\Core\Auth\Actions\Logout;
use Application\Modules\Core\Auth\Actions\Register;
use Application\Modules\Core\Auth\Actions\ResetPassword;
use Illuminate\Http\Request;
use Application\Modules\BaseController;

class Auth_Controller extends BaseController
{

    public function mobileLogin(Request $request) {
        $result = Login::boot($request->all(), 'mobile');
        return sendResponse($result);
    }

    public function login(Request $request) {
        $result = Login::boot($request->all(), 'spa');
        return sendResponse($result);
    }

    public function logout() {
        $result = Logout::boot();
        return sendResponse($result);
    }

    public function user() {
        $result = GetCurrentLoggedInUser::boot();
        return sendResponse($result);
    }

    //https://victorighalo.medium.com/custom-password-reset-in-laravel-21e57816989f
    public function forgotPassword(Request $request) {
        $result = ForgotPassword::boot($request->all());
        return sendResponse($result);

    }

    public function resetPassword(Request $request) {
        $result = ResetPassword::boot($request->all());
        return sendResponse($result);

    }

    public function register(Request $request) {
        $result = Register::boot($request->all());
        return sendResponse($result);

    }
}

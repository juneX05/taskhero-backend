<?php


namespace Application\Modules\Core\Auth;


use Application\Modules\Core\Menus\Menus_Actions;
use Application\Modules\Core\Users\Users_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class Auth_Actions
{
    private static $ACTOR = 'User';

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private static function validate($data) {
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()];
        }
        return ['status' => true, 'data' => $validator->validated()];
    }

    private static function validateLogin($data) {
        $validator = Validator::make($data, [
            'password' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()];
        }
        return ['status' => true, 'data' => $validator->validated()];
    }

    public static function login($request_data) {
        $validation = self::validateLogin($request_data);
        if (!$validation['status']) return sendValidationError($validation['error']);

        $data = $validation['data'];

        $auth = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if ($auth) {
            $user = Auth::user();

            if ($user->user_status_id == 1) {
                logInfo(__FUNCTION__,[
                    'actor_id' => $user->urid,
                    'actor' => self::$ACTOR,
                    'action_description' => 'User Logged In',
                    'old_data' => null,
                    'new_data' => json_encode($user),
                ],'USER-LOGIN');

                $token = $user->createToken('AuthToken')->plainTextToken;
                $user['token'] = $token;
                return sendResponse('Login Successful', $user);
            }

            return sendError('Your Account is not active, Please contact administrator if the problem persists.',401);
        }
        return sendError('Login Failed',401);
    }

    public static function logout() {
        $request = request();
        if ($request->bearerToken())
            PersonalAccessToken::findToken($request->bearerToken())->delete();
        else {
            $user = $request->user();
            $user->tokens()->where('id', auth()->id())->delete();
            Auth::guard('web')->logout();
        }

        logInfo(__FUNCTION__,[
            'actor_id' => $request->user()->urid,
            'actor' => self::$ACTOR,
            'action_description' => 'User Logged Out',
            'old_data' => json_encode($request->user()),
            'new_data' => json_encode([]),
        ],'USER-LOGOUT');

        return sendResponse('User Logged Out', null);
    }

    public static function currentUser() {
        if(!verifyRequest()) return sendError('Unauthenticated', 401);

        $user = request()->user();

        $sidebar_menus = Menus_Actions::sidebarMenus();

        $response = [
            'permissions' => getUserPermissions($user->id),
            'user' => $user,
            'menus' => $sidebar_menus
        ];
        return sendResponse('User Data',$response );
    }
}

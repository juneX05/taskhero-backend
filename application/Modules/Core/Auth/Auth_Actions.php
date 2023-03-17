<?php


namespace Application\Modules\Core\Auth;


use Application\Modules\BaseModel;
use Application\Modules\Core\Menus\Menus_Actions;
use Application\Modules\Core\Users\_Modules\UserStatus\UserStatus;
use Application\Modules\Core\Users\Users_Actions;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\ProfileManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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

    public static function mobileLogin($request_data) {
        $validation = self::validateLogin($request_data);
        if (!$validation['status']) return sendValidationError($validation['error']);

        $data = $validation['data'];

        $user = Users_Model::where('email', $data['email'])->first();

        if (!$user) {
            return sendError('Email or Password is incorrect.',401);
        }

        $password_check = Hash::check($data['password'], $user->password);
        if (!$password_check) {
            return sendError('Login Failed',401);
        }

        if ($user->user_status_id != 1) {
            return sendError('Your Account is not active, Please contact administrator if the problem persists.',401);
        }

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

            if ($user->user_status_id == UserStatus::ACTIVE) {
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
        if ($request->bearerToken()) {
            $token = PersonalAccessToken::findToken($request->bearerToken());
            if ($token == null) {
                return sendError('Invalid Token', 500);
            }

            $token->delete();
        }
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

        $profile = ProfileManager::fetch(request()->user());
        if (!$profile['status']) {
            return sendError('User has no profile', 500);
        }

        $user = $profile['data']['user'];

        $sidebar_menus = Menus_Actions::sidebarMenus();

        $response = [
            'permissions' => getUserPermissions(request()->user()->id),
            'user' => $user,
            'menus' => $sidebar_menus
        ];
        return sendResponse('User Data',$response );
    }

    public static function forgotPassword($request_data) {
        $validation = validateData($request_data, [
            'email' => ['required','email']
        ]);

        if (!$validation['status']) return sendValidationError($validation['error']);

        $data = $validation['data'];

        $user = Users_Model::whereEmail($data['email'])->first();

        if (!$user) {
            return sendError('User not Found', 404);
        }

        $data['token'] = Str::random(60);
        $data['created_at'] = date('Y-m-d H:i:s');

        DB::table('password_resets')->insert($data);

        $reset_password = DB::table('password_resets')
            ->where('token', $data['token'])->first();

        $token = $reset_password->token;

        if (self::sendResetEmail($user, $token)) {
            return sendResponse('A reset link has been sent to your email address.');
        } else {
            return sendError('A Network Error occurred. Please try again.', 500);
        }
    }

    private static function sendResetEmail(Users_Model $user, $token)
    {
        //Generate, the password reset link. The token generated is embedded in the link
        $link = env('APP_URL') . '/api/password/reset?token=' . $token . '&email=' . urlencode($user->email);

        try {
            //Here send the link with CURL with an external email API
            Mail::raw($link
                , function ($message) use ($user) {
                $message->to($user->email, $user->name)->subject('Reset Password Email');
                $message->from('joelvankibona@gmail.com', 'Joel Kibona');
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function resetPassword($request_data) {

        $validation = validateData($request_data, [
            'email' => ['required','email'],
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        if (!$validation['status']) return sendValidationError($validation['error']);

        $data = $validation['data'];

        $user = Users_Model::whereEmail($data['email'])->first();
        if (!$user) {
            return sendError('Not Found', 404);
        }

        $reset_password = DB::table('password_resets')
            ->where('token', $data['token'])->first();

        if (!$reset_password) {
            return sendError('Invalid Token', 404);
        }

        $update = $user->update(['password' => bcrypt($data['password'])]);
        if (!$update) {
            return sendError('Failed to Reset Password', 500);
        }

        DB::table('password_resets')
            ->where('token', $data['token'])->delete();

        if (self::sendResetSuccessfulEmail($user)) {
            return sendResponse('A reset link has been sent to your email address.');
        } else {
            return sendError('A Network Error occurred. Please try again.', 500);
        }
    }

    private static function sendResetSuccessfulEmail(Users_Model $user)
    {
        //Generate, the password reset link. The token generated is embedded in the link
        try {
            //Here send the link with CURL with an external email API
            Mail::raw('Your Password has been updated successfully'
                , function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject('Password Reset Successful');
                    $message->from('joelvankibona@gmail.com', 'Joel Kibona');
                });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function register($request_data) {
        $validation = validateData($request_data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if (!$validation['status']) return sendValidationError($validation['error']);

        $data = $validation['data'];
        $data['password'] = bcrypt($data['password']);

        $data['user_status_id'] = UserStatus::PENDING;
        $user = Users_Model::create($data);

        if (!$user) return sendError('Registration Failed', 500);

        return sendResponse('Registration Successful');
    }
}

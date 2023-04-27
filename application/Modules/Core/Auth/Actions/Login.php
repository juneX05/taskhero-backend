<?php

namespace Application\Modules\Core\Auth\Actions;

use Application\Modules\Core\Auth\Auth;
use Application\Modules\Core\Users\_Modules\UserStatus\UserStatus;
use Application\Modules\Core\Users\Users_Model;
use Illuminate\Support\Facades\Auth as Authentication;
use Illuminate\Support\Facades\Hash;

class Login
{
    public static function boot($request_data, $authentication_type) {
        $validation = self::validate($request_data);
        if (!$validation['status']) return error($validation);

        $data = $validation['data'];

        if ($authentication_type == 'spa') {

            $auth = Authentication::attempt([
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            if (!$auth) {
                return error('Login Failed');
            }
            $user = Users_Model::where('email', $data['email'])
                ->first();
        } else {

            $user = Users_Model::where('email', $data['email'])
                ->first();

            if (!$user) {
                return error('Email or Password is incorrect.', 401);
            }

            $password_check = Hash::check($data['password'], $user->password);
            if (!$password_check) {
                return error('Login Failed',401);
            }
        }

        if ($user->user_status_id != UserStatus::ACTIVE) {
            return error('Your Account is not active, Please contact administrator if the problem persists.');
        }

        //Log logged in user information
        Auth::logLogin($user->toArray());

        $token = $user->createToken('AuthToken')->plainTextToken;
        $user['token'] = $token;

        return success('Login Successful', $user);

    }

    private static function validate($data) {
        return validateData($data, [
            'password' => 'required',
            'email' => 'required',
        ]);
    }


}

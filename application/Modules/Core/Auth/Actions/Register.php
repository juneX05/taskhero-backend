<?php

namespace Application\Modules\Core\Auth\Actions;

use Application\Modules\Core\Users\_Modules\UserStatus\UserStatus;
use Application\Modules\Core\Users\Users_Model;

class Register
{
    public static function boot($request_data) {
        $validation = validateData($request_data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if (!$validation['status']) return error($validation);

        $data = $validation['data'];
        $data['password'] = bcrypt($data['password']);

        $data['user_status_id'] = UserStatus::PENDING;
        $user = Users_Model::create($data);

        if (!$user) return error('Registration Failed');

        return success('Registration Successful');
    }
}

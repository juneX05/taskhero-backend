<?php

namespace Application\Modules\Core\Auth\Actions;

use Application\Modules\Core\Users\Users_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ResetPassword
{
    public static function boot($request_data) {

        $validation = validateData($request_data, [
            'email' => ['required','email'],
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        if (!$validation['status']) return error($validation);

        $data = $validation['data'];

        $user = Users_Model::whereEmail($data['email'])->first();
        if (!$user) {
            return error('Not Found', 404);
        }

        $reset_password = DB::table('password_reset_tokens')
            ->where('token', $data['token'])->first();

        if (!$reset_password) {
            return error('Invalid Token', 404);
        }

        $update = $user->update(['password' => bcrypt($data['password'])]);
        if (!$update) {
            return error('Failed to Reset Password');
        }

        DB::table('password_reset_tokens')
            ->where('token', $data['token'])->delete();

        if (self::sendResetSuccessfulEmail($user)) {
            return success('A reset link has been sent to your email address.');
        } else {
            return error('A Network Error occurred. Please try again.');
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
}

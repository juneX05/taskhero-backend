<?php

namespace Application\Modules\Core\Auth\Actions;

use Application\Modules\Core\Users\Users_Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPassword
{
    public static function boot($request_data) {
        $validation = validateData($request_data, [
            'email' => ['required','email']
        ]);

        if (!$validation['status']) return error($validation);

        $data = $validation['data'];

        $user = Users_Model::whereEmail($data['email'])->first();

        if (!$user) {
            return error('User not Found', 404);
        }

        $data['token'] = Str::random(60);
        $data['created_at'] = date('Y-m-d H:i:s');

        DB::table('password_reset_tokens')->insert($data);

        $reset_password = DB::table('password_reset_tokens')
            ->where('token', $data['token'])->first();

        $token = $reset_password->token;

        if (self::sendResetEmail($user, $token)) {
            return success('A reset link has been sent to your email address.');
        } else {
            return error('A Network Error occurred. Please try again.');
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
}

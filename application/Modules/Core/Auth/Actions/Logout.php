<?php

namespace Application\Modules\Core\Auth\Actions;

use Application\Modules\Core\Auth\Auth;
use Illuminate\Support\Facades\Auth as Authenticator;
use Laravel\Sanctum\PersonalAccessToken;

class Logout
{
    public static function boot() {
        $request = request();
        $user = $request->user();
        if ($request->bearerToken()) {
            $token = PersonalAccessToken::findToken($request->bearerToken());
            if ($token == null) {
                return error('Invalid Token');
            }

            $token->delete();
        }
//        else {
        $user->currentAccessToken()->delete();
            $user->tokens()->delete();
            Authenticator::guard('web')->logout();
//        }

        Auth::logLogout($user->toArray());

        return success('User Logged Out');
    }
}

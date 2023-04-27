<?php

namespace Application\Modules\Core\Auth;

use Application\Modules\Core\Logs\Logs;
use Application\Modules\System\Projects\Projects;

class Auth
{
    const ACTOR = 'Auth';

    public static function getRecord() {
        return \Illuminate\Support\Facades\Auth::user();
    }

    public static function logLogin($user) {
        Logs::saveLog(
            self::ACTOR
            ,'User Login'
            ,'login'
            , $user
        );
    }

    public static function logLogout($user) {
        Logs::saveLog(
            self::ACTOR
            ,'User Logout'
            ,'logout'
            , $user
        );
    }
}

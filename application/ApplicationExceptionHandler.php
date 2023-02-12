<?php


namespace Application;


use App\Exceptions\Handler;
use Application\Modules\Core\Logs\Logs_Actions;
use Illuminate\Auth\AuthenticationException;

class ApplicationExceptionHandler extends Handler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        Logs_Actions::$ACTOR = 'AUTHENTICATION_EXCEPTION';
        Logs_Actions::$REQUEST_ID = 'REQ' . hrtime(true);

        return sendError('Authentication Failed', 401);
    }
}

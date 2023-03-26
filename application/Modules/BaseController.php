<?php


namespace Application\Modules;


use App\Http\Controllers\Controller;
use Application\Modules\Core\Logs\Logs;
use Application\Modules\Core\Logs\Logs_Actions;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $ACTOR = explode('\\', get_called_class());
            Logs::$ACTOR = str_replace('_Controller', '', end($ACTOR));
            Logs::$REQUEST_ID = 'REQ' . hrtime(true);
            Logs_Actions::initiateLog();

            return $next($request);
        });
    }
}

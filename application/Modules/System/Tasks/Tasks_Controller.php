<?php

namespace Application\Modules\System\Tasks;

use Application\Modules\BaseController;
use Illuminate\Http\Request;

class Tasks_Controller extends BaseController
{

    public function index()
    {
        return Tasks_Actions::index();
    }

    public function myTasks()
    {
        return Tasks_Actions::myTasks();
    }

    public function splash()
    {
        return Tasks_Actions::splash();
    }

    public function save(Request $request)
    {
        return Tasks_Actions::saveTask($request->all());
    }

}

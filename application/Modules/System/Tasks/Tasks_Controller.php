<?php

namespace Application\Modules\System\Tasks;

use Application\Modules\BaseController;
use Application\Modules\Core\Logs\Logs_Actions;
use Application\Modules\System\Tasks\Actions\ActionCompleteTask;
use Application\Modules\System\Tasks\Actions\ActionCreateTask;
use Application\Modules\System\Tasks\Actions\ActionReOpenTask;
use Application\Modules\System\Tasks\Actions\ActionUpdateTask;
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
        return ActionCreateTask::boot($request->all());
    }

    public function view($urid)
    {
        return Tasks_Actions::viewTask($urid);
    }

    public function update(Request $request, $urid)
    {
        return ActionUpdateTask::boot($request->all(), $urid);
    }

    public function complete(Request $request, $urid)
    {
        return ActionCompleteTask::boot($request->all(), $urid);
    }

    public function reOpen(Request $request, $urid)
    {
        return ActionReOpenTask::boot($request->all(), $urid);
    }
}

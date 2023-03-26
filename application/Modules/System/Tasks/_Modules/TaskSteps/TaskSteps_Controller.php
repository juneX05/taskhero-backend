<?php

namespace Application\Modules\System\Tasks\_Modules\TaskSteps;
use Application\Modules\BaseController;
use Application\Modules\Core\Logs\Logs_Actions;
use Application\Modules\System\Tasks\_Modules\TaskSteps\Actions\ActionCreateStep;
use Application\Modules\System\Tasks\Actions\ActionCompleteTask;
use Application\Modules\System\Tasks\Actions\ActionCreateTask;
use Application\Modules\System\Tasks\Actions\ActionReOpenTask;
use Application\Modules\System\Tasks\Actions\ActionUpdateTask;
use Illuminate\Http\Request;

class TaskSteps_Controller extends BaseController
{

    public function save(Request $request, $task_urid)
    {
        return ActionCreateStep::boot($request->all(), $task_urid);
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

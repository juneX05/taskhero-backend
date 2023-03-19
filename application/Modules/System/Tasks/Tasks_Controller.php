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

    public function view($urid)
    {
        return Tasks_Actions::viewNotifier($urid);
    }

    public function statuses()
    {
        return Tasks_Actions::getNotifierStatuses();
    }

    public function save(Request $request) {
       return Tasks_Actions::saveNotifier($request->all());
    }

    public function update(Request $request, $urid) {
        return Tasks_Actions::updateNotifier($request->all(), $urid);
    }

    public function deactivate($urid) {
        return Tasks_Actions::deactivateNotifier($urid);
    }

    public function activate($urid) {
        return Tasks_Actions::activateNotifier($urid);
    }

}

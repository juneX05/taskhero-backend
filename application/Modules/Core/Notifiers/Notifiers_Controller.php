<?php

namespace Application\Modules\Core\Notifiers;

use Application\Modules\BaseController;
use Application\Modules\Core\Notifiers\Notifiers_Actions;
use Illuminate\Http\Request;

class Notifiers_Controller extends BaseController
{

    public function index()
    {
        $result = Notifiers_Actions::index();
        return sendResponse($result);
    }

    public function view($urid)
    {
        $result = Notifiers_Actions::viewNotifier($urid);
        return sendResponse($result);
    }

    public function statuses()
    {
        $result = Notifiers_Actions::getNotifierStatuses();
        return sendResponse($result);
    }

    public function save(Request $request) {
       $result = Notifiers_Actions::saveNotifier($request->all());
        return sendResponse($result);
    }

    public function update(Request $request, $urid) {
        $result = Notifiers_Actions::updateNotifier($request->all(), $urid);
        return sendResponse($result);
    }

    public function deactivate($urid) {
        $result = Notifiers_Actions::deactivateNotifier($urid);
        return sendResponse($result);
    }

    public function activate($urid) {
        $result = Notifiers_Actions::activateNotifier($urid);
        return sendResponse($result);
    }

}

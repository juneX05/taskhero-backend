<?php

namespace Application\Modules\Core\Notifiers;

use Application\Modules\BaseController;
use Application\Modules\Core\Notifiers\Notifiers_Actions;
use Illuminate\Http\Request;

class Notifiers_Controller extends BaseController
{

    public function index()
    {
        return Notifiers_Actions::index();
    }

    public function view($urid)
    {
        return Notifiers_Actions::viewNotifier($urid);
    }

    public function statuses()
    {
        return Notifiers_Actions::getNotifierStatuses();
    }

    public function save(Request $request) {
       return Notifiers_Actions::saveNotifier($request->all());
    }

    public function update(Request $request, $urid) {
        return Notifiers_Actions::updateNotifier($request->all(), $urid);
    }

    public function deactivate($urid) {
        return Notifiers_Actions::deactivateNotifier($urid);
    }

    public function activate($urid) {
        return Notifiers_Actions::activateNotifier($urid);
    }

}

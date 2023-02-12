<?php

namespace Application\Modules\Core\Status;

use Application\Modules\BaseController;

class Status_Controller extends BaseController
{

    public function index()
    {

        $permissions = Status_Model::all();

        return sendResponse($permissions, 'Permissions Data');
    }
}

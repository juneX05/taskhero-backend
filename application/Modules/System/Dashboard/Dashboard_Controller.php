<?php

namespace Application\Modules\System\Dashboard;

use Application\Modules\BaseController;

class Dashboard_Controller extends BaseController
{

    public function index()
    {
        return Dashboard_Actions::index();
    }
}

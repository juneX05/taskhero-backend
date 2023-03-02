<?php

namespace Application\Modules\System\Dashboard;

use Application\Modules\BaseController;
use Application\Modules\Core\Users\_Modules\UserTypes\UserTypes;
use Application\Modules\Core\Users\Users;
use Illuminate\Support\Facades\Auth;

class Dashboard_Controller extends BaseController
{
    public function index()
    {
        switch (Auth::user()->user_type_id) {
            case UserTypes::ADMIN_ID:
                return Dashboard_Actions::dashboard_admin();

            case UserTypes::DEVELOPER_ID:
                return Dashboard_Actions::dashboard_developer();

            default:
                return sendResponse('Dashboard Success', []);
        }
    }
}

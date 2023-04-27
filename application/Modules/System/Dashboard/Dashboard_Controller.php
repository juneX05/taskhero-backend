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
                $result = Dashboard_Actions::dashboard_admin();
                break;
            case UserTypes::DEVELOPER_ID:
                $result =  Dashboard_Actions::dashboard_developer();
                break;
            default:
                $result =  ['status' => true, 'message' => "Success"];
        }

        return sendResponse($result);
    }
}

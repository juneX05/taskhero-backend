<?php

namespace Application\Modules\System\Dashboard;

use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Priority\Priority;
use Application\Modules\System\Projects\Projects_Model;
use Application\Modules\System\Tasks\Tasks;
use Application\Modules\System\Tasks\Tasks_Model;

class Dashboard_Actions
{
    private static function data() {
        $data = [];
        $data['tasks'] = Tasks_Model::all()->count();
        $data['overdue_tasks'] = Tasks_Model::where('end_date','<', date('Y-m-d'))->count();
        $data['projects'] = Projects_Model::all()->count();
        $data['users'] = Users_Model::all()->count();
        $data['high_priority_tasks'] = Tasks_Model::wherePriorityId(Priority::HIGH)->count();

        return $data;
    }
    public static function dashboard_developer() {
        return sendResponse('Developer Dashboard', self::data());
    }

    public static function dashboard_super_admin() {
        return sendResponse('Super Admin Dashboard', self::data());
    }

    public static function dashboard_admin() {
        return sendResponse('Admin Dashboard', self::data());
    }
}

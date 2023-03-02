<?php

namespace Application\Modules\System\Dashboard;

class Dashboard_Actions
{
    public static function dashboard_developer() {
        return sendResponse('Developer Dashboard', ['records' => 0]);
    }

    public static function dashboard_super_admin() {
        return sendResponse('Super Admin Dashboard', ['records' => 0]);
    }

    public static function dashboard_admin() {
        return sendResponse('Admin Dashboard', ['records' => 0]);
    }
}

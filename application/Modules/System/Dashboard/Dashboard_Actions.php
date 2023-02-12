<?php

namespace Application\Modules\System\Dashboard;

class Dashboard_Actions
{
    public static function index() {
        return sendResponse('Success', []);
    }
}

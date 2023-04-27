<?php

namespace Application\Modules\Core\Menus;

use Application\Modules\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Menus_Controller extends BaseController
{

    public function index()
    {
        $result = Menus_Actions::index();
        return sendResponse($result);
    }

    public function parents()
    {
        $result = Menus_Actions::getParentMenus();
        return sendResponse($result);
    }

    public function menuRoutes()
    {
        $result = Menus_Actions::getMenuRoutes();
        return sendResponse($result);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request) {
        $result = Menus_Actions::saveMenu($request->all());
        return sendResponse($result);
    }

    public function update(Request $request) {
        $result = Menus_Actions::updateMenu($request->all());
        return sendResponse($result);
    }

    public function delete(Request $request) {
        $result = Menus_Actions::deleteMenu($request->all());
        return sendResponse($result);
    }

    public function updatePositions(Request $request) {
        $result = Menus_Actions::updatePositions($request->all() );
        return sendResponse($result);
    }
}

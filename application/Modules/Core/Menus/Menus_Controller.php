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
        return Menus_Actions::index();
    }

    public function parents()
    {
        return Menus_Actions::getParentMenus();
    }

    public function menuRoutes()
    {
        return Menus_Actions::getMenuRoutes();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request) {
        return Menus_Actions::saveMenu($request->all());
    }

    public function update(Request $request) {
        return Menus_Actions::updateMenu($request->all());
    }

    public function delete(Request $request) {
        return Menus_Actions::deleteMenu($request->all());
    }

    public function updatePositions(Request $request) {
        return Menus_Actions::updatePositions($request->all() );
    }
}

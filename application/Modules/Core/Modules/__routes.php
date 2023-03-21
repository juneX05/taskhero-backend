<?php

use Application\Modules\Core\Modules\Modules_Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('/modules')
    ->controller(Modules_Controller::class)
    ->group(function () {

        Route::get('', 'index');
        Route::get('/statuses', 'statuses');
        Route::post('/save', 'save');
        Route::post('/update', 'update');
        Route::post('/change-status', 'changeStatus');
        Route::get('/{module_id}/view', 'view');

        Route::post('/seed', function (\Illuminate\Http\Request $request) {
            \Application\Modules\Core\Modules\Modules::runSeeder($request['class']);
        });

    })
;

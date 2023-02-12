<?php

use Application\Modules\Core\Roles\Roles_Controller;

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/roles', [Roles_Controller::class,'index']);
        Route::get('/roles/{urid}/view', [Roles_Controller::class,'view']);
        Route::post('/roles/{urid}/update', [Roles_Controller::class,'update']);
        Route::post('/roles/save', [Roles_Controller::class,'save']);
        Route::post('/roles/{urid}/change-role-permissions', [Roles_Controller::class,'changePermissions']);
        Route::post('/roles/{urid}/change-role-status', [Roles_Controller::class,'changeStatus']);
        Route::post('/roles/statuses', [Roles_Controller::class,'statuses']);
    });

<?php

use Application\Modules\Core\Roles\Roles_Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/roles', [Roles_Controller::class,'index']);
        Route::get('/roles/{urid}/view', [Roles_Controller::class,'view']);
        Route::post('/roles/{urid}/update', [Roles_Controller::class,'update']);
        Route::post('/roles/save', [Roles_Controller::class,'save']);
        Route::post('/roles/{urid}/change-permissions', [Roles_Controller::class,'changePermissions']);
        Route::get('/roles/{urid}/get-permissions', [Roles_Controller::class, 'getPermissions']);
        Route::post('/roles/{urid}/activate', [Roles_Controller::class,'activate']);
        Route::post('/roles/{urid}/deactivate', [Roles_Controller::class,'deactivate']);
        Route::get('/roles/statuses', [Roles_Controller::class,'getRoleStatuses']);
    });

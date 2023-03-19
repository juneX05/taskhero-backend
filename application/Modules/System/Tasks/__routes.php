<?php

use Application\Modules\System\Tasks\Tasks_Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('/tasks')
    ->group(function () {

        Route::get('', [Tasks_Controller::class, 'index']);
        Route::get('/statuses', [Tasks_Controller::class, 'statuses']);
        Route::post('/save', [Tasks_Controller::class, 'save']);
        Route::post('/{urid}/update', [Tasks_Controller::class, 'update']);
        Route::get('/{urid}/view', [Tasks_Controller::class, 'view']);

    })
;

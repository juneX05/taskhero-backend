<?php

use Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps_Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('/tasks/{task_urid}/steps')
    ->group(function () {

        Route::post('/save', [TaskSteps_Controller::class, 'save']);
        Route::post('/{urid}/update', [TaskSteps_Controller::class, 'update']);
        Route::get('/{urid}/view', [TaskSteps_Controller::class, 'view']);

        Route::post('/{urid}/mark-step', [TaskSteps_Controller::class, 'markStep']);

    })
;

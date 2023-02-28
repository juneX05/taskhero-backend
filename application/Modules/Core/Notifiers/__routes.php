<?php

use Application\Modules\Core\Notifiers\Notifiers_Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('/notifiers')
    ->controller(Notifiers_Controller::class)
    ->group(function () {

        Route::get('', 'index');
        Route::get('/statuses', 'statuses');
        Route::post('/save', 'save');
        Route::post('/{urid}/update', 'update');
        Route::get('/{urid}/view', 'view');
        Route::post('/{urid}/activate', 'activate');
        Route::post('/{urid}/deactivate', 'deactivate');

    })
;

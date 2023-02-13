<?php

use Application\Modules\Core\Permissions\Permissions_Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
->group(function () {
    Route::get('/permissions', [Permissions_Controller::class, 'index']);
    Route::post('/permissions/save', [Permissions_Controller::class, 'save']);
    Route::post('/permissions/update', [Permissions_Controller::class, 'update']);
});

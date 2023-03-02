<?php

use Application\Modules\System\Dashboard\Dashboard_Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/dashboard', [
            Dashboard_Controller::class,
            'index'
        ]);
    });

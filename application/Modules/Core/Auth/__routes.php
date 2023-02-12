<?php

use Application\Modules\Core\Auth\Auth_Controller;
use Illuminate\Support\Facades\Route;

Route::post('/login', [
    Auth_Controller::class,
    'login'
]);

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::post('/logout', [
            Auth_Controller::class,
            'logout'
        ]);
        Route::get('/user', [
            Auth_Controller::class,
            'user'
        ]);
    });

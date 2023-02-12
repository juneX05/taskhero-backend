<?php

use Application\Modules\Core\Users\Users_Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->group(function () {

        Route::get('/users', [Users_Controller::class, 'index']);
        Route::get('/users/profile', [Users_Controller::class, 'profile']);
        Route::get('/users/user-types', [Users_Controller::class, 'userTypes']);
        Route::get('/users/{urid}/view', [Users_Controller::class, 'view']);
        Route::post('/users/change-user-password', [Users_Controller::class, 'changeUserPassword']);
        Route::post('/users/change-password', [Users_Controller::class, 'changePassword']);
        Route::post('/users/change-user-permissions', [Users_Controller::class, 'changeUserPermissions']);
        Route::post('/users/change-user-roles', [Users_Controller::class, 'changeUserRoles']);
        Route::post('/users/save', [Users_Controller::class, 'save']);

    });

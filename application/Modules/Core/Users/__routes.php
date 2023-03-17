<?php

use Application\Modules\Core\Users\Users_Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->group(function () {

        Route::get('/users', [Users_Controller::class, 'index']);
        Route::get('/users/profile', [Users_Controller::class, 'profile']);
        Route::post('/users/profile/update', [Users_Controller::class, 'profileUpdate']);
        Route::get('/users/splash', [Users_Controller::class, 'splash']);
        Route::get('/users/{urid}/view', [Users_Controller::class, 'view']);
        Route::post('/users/change-user-password', [Users_Controller::class, 'changeUserPassword']);
        Route::post('/users/change-password', [Users_Controller::class, 'changePassword']);
        Route::post('/users/{urid}/change-permissions', [Users_Controller::class, 'changePermissions']);
        Route::get('/users/{urid}/get-permissions', [Users_Controller::class, 'getPermissions']);
        Route::post('/users/{urid}/change-roles', [Users_Controller::class, 'changeRoles']);
        Route::post('/users/{urid}/complete-user-registration', [Users_Controller::class, 'completeRegistration']);
        Route::post('/users/save', [Users_Controller::class, 'save']);
        Route::post('/users/{urid}/update-account-details', [Users_Controller::class, 'updateAccountDetails']);
        Route::post('/users/{urid}/activate', [Users_Controller::class, 'activate']);
        Route::post('/users/{urid}/deactivate', [Users_Controller::class, 'deactivate']);

    });

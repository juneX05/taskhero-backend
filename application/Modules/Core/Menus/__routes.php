<?php

use Application\Modules\Core\Menus\Menus_Controller;
use Illuminate\Support\Facades\Route;

Route::get('/menus', [Menus_Controller::class,'index']);
Route::get('/menus/routes', [Menus_Controller::class,'menuRoutes']);

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/menus/parent', [Menus_Controller::class,'parents']);
        Route::post('/menus/save', [Menus_Controller::class,'save']);
        Route::post('/menus/update', [Menus_Controller::class,'update']);
        Route::post('/menus/update-positions', [Menus_Controller::class,'updatePositions']);
        Route::post('/menus/delete', [Menus_Controller::class,'delete']);
    });

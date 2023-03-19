<?php

use Application\Modules\System\Projects\Projects_Controller;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/projects', [Projects_Controller::class,'index']);
        Route::get('/projects/splash', [Projects_Controller::class,'splash']);
        Route::get('/projects/routes', [Projects_Controller::class,'menuRoutes']);
        Route::get('/projects/parent', [Projects_Controller::class,'parents']);
        Route::post('/projects/save', [Projects_Controller::class,'save']);
        Route::post('/projects/update', [Projects_Controller::class,'update']);
        Route::post('/projects/update-positions', [Projects_Controller::class,'updatePositions']);
        Route::post('/projects/delete', [Projects_Controller::class,'delete']);
    });

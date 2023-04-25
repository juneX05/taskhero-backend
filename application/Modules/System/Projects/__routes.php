<?php

use Application\Modules\System\Projects\Projects_Controller;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/projects', [Projects_Controller::class,'index']);
        Route::get('/projects/splash', [Projects_Controller::class,'splash']);
        Route::get('/projects/{urid}/view', [Projects_Controller::class,'view']);
        Route::post('/projects/save', [Projects_Controller::class,'save']);
        Route::post('/projects/{urid}/update', [Projects_Controller::class,'update']);

    });

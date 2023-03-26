<?php


use Application\Modules\Core\Logs\Logs;

Route::middleware('auth:sanctum')
    ->prefix('/logs')
    ->group(function () {
        Route::get('/{module}/{record_id}/history', function ($module, $record_id) {
            $history = Logs::pullHistory($module, $record_id);
            return sendResponse('Timeline Pulled', $history);
        });
    });




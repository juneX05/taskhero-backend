<?php

use Application\Modules\Core\Media\Media_Controller;

Route::get('/media/{urid}/view', [
    Media_Controller::class,
    'view'
]);

<?php

namespace Application\Modules\Core\Notifiers;


use Application\Modules\BaseModel;

class Notifiers_Model extends BaseModel {
    protected $table = 'notifiers';

    protected $fillable = [
        'name',
        'title',
        'description',
        'message',
        'type',
        'status_id',
        'urid'
    ];
}

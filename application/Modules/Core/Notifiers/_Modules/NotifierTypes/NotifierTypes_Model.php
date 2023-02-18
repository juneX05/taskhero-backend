<?php

namespace Application\Modules\Core\Notifiers\_Modules\NotifierTypes;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotifierTypes_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'notifier_types';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'title',
        'color',
        'urid',
    ];
}

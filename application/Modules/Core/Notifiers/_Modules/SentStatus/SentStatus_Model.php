<?php

namespace Application\Modules\Core\Notifiers\_Modules\SentStatus;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SentStatus_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'sent_status';
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

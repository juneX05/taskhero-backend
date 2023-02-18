<?php

namespace Application\Modules\Core\Notifiers\_Modules\NotifierQueues;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotifierQueues_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'notifier_queues';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sender_name',
        'sender',
        'recipient_name',
        'recipient',
        'message',
        'subject',
        'notifier_type_id',
        'sent_status_id',
        'urid',
    ];
}

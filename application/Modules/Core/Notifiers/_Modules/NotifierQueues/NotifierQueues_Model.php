<?php

namespace Application\Modules\Core\Notifiers\_Modules\NotifierQueues;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Notifiers\_Modules\NotifierQueues\NotifierQueues_Model
 *
 * @property int $id
 * @property string $sender_name
 * @property string $sender
 * @property string $recipient_name
 * @property string $recipient
 * @property string $message
 * @property string $subject
 * @property int $notifier_type_id
 * @property int $sent_status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereNotifierTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereRecipientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereSenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereSentStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierQueues_Model whereUrid($value)
 * @mixin \Eloquent
 */
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

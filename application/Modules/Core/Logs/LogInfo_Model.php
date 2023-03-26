<?php

namespace Application\Modules\Core\Logs;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Logs\LogInfo_Model
 *
 * @property int $id
 * @property string $request_id
 * @property string $actor
 * @property int|null $actor_id
 * @property string $action_type
 * @property string $action_name
 * @property string|null $action_description
 * @property string|null $old_data
 * @property string $new_data
 * @property string $urid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereActionDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereActionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereActor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereActorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereNewData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereOldData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogInfo_Model whereUrid($value)
 * @mixin \Eloquent
 */
class LogInfo_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'logs_info';
    protected $fillable = [
        'request_id',
        'actor',
        'actor_id',
        'action_type',
        'action_name',
        'action_description',
        'old_data',
        'new_data',
        'urid',
    ];
    protected $connection = 'db_log';

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

     public function request()
     {
         return $this->belongsTo(Logs_Model::class, 'request_id','request_id');
     }
}

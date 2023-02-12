<?php

namespace Application\Modules\Core\Logs;

use Application\Modules\BaseModel;


/**
 * Application\Modules\Core\Logs\Logs_Model
 *
 * @property int $id
 * @property string $request_id
 * @property string $request_url
 * @property string $request_data
 * @property string $request_method
 * @property string|null $request_content_type
 * @property string $request_client_ips
 * @property int|null $user_id
 * @property string $user
 * @property string $urid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Application\Modules\Core\Logs\LogInfo_Model[] $traces
 * @property-read int|null $traces_count
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereRequestClientIps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereRequestContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereRequestData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereRequestMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereRequestUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs_Model whereUserId($value)
 * @mixin \Eloquent
 */
class Logs_Model extends BaseModel {
    protected $table = 'logs';
    protected $fillable = [
        'request_id',
        'request_url',
        'request_data',
        'request_content_type',
        'request_method',
        'request_client_ips',
        'user_id',
        'user',
        'urid',
    ];
    public $connection = 'db_log';

    public function traces()
    {
        return $this->hasMany(LogInfo_Model::class, 'request_id', 'request_id');
    }
}
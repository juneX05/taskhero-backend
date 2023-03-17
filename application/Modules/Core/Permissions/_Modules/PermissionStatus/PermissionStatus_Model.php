<?php

namespace Application\Modules\Core\Permissions\_Modules\PermissionStatus;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Status\PermissionStatus_Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionStatus_Model whereUrid($value)
 */
class PermissionStatus_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'permission_status';
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

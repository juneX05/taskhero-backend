<?php

namespace Application\Modules\Core\Users\_Modules\UserPermissions;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions_Model
 *
 * @property int $id
 * @property int $user_id
 * @property int $permission_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions_Model whereUserId($value)
 * @mixin \Eloquent
 */
class UserPermissions_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'user_permissions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'permission_id',
        'status_id',
        'urid',
    ];
}

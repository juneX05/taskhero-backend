<?php

namespace Application\Modules\Core\RolePermissions;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\RolePermissions\RolePermissions_Model
 *
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissions_Model whereUrid($value)
 * @mixin \Eloquent
 */
class RolePermissions_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'role_permissions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'permission_id',
        'status_id',
        'urid',
    ];
}

<?php

namespace Application\Modules\Core\Roles\_Modules\RoleTypes;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Roles\_Modules\RoleTypes\RoleTypes_Model
 *
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleTypes_Model whereUrid($value)
 * @mixin \Eloquent
 */
class RoleTypes_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'role_types';
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

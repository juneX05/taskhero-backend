<?php

namespace Application\Modules\Core\Users\_Modules\UserRoles;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Users\_Modules\UserRoles\UserRoles_Model
 *
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles_Model whereUserId($value)
 * @mixin \Eloquent
 */
class UserRoles_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'user_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'role_id',
        'status_id',
        'urid',
    ];
}

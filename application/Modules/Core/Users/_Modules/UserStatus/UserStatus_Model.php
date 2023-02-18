<?php

namespace Application\Modules\Core\Users\_Modules\UserStatus;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Users\_Modules\UserStatus\UserStatus_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserStatus_Model whereUrid($value)
 * @mixin \Eloquent
 */
class UserStatus_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'user_status';
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

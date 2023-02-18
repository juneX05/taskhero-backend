<?php

namespace Application\Modules\Core\Users\_Modules\UserTypes;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Users\_Modules\UserTypes\UserTypes_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property int $user_id
 * @property string|null $description
 * @property string $table
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTypes_Model whereUserId($value)
 * @mixin \Eloquent
 */
class UserTypes_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'user_types';
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
        'user_id',
        'description',
        'table',
        'urid',
    ];
}

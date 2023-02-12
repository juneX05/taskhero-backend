<?php

namespace Application\Modules\Core\Status;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Status\Status_Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status_Model whereUrid($value)
 */
class Status_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'status';
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

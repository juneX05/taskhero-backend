<?php

namespace Application\Modules\System\Priorities;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Priorities\Priorities_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priorities_Model whereUrid($value)
 * @mixin \Eloquent
 */
class Priorities_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'priorities';
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

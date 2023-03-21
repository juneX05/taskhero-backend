<?php

namespace Application\Modules\System\Projects\_Modules\ProjectPositions;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Projects\_Modules\ProjectPositions\ProjectPositions_Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model query()
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectPositions_Model whereUrid($value)
 * @mixin \Eloquent
 */
class ProjectPositions_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'project_positions';
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

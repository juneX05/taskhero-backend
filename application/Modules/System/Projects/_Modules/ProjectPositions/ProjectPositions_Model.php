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

<?php

namespace Application\Modules\System\Projects\_Modules\ProjectAssignees;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Projects\_Modules\ProjectAssignees\ProjectAssignees_Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model query()
 * @mixin \Eloquent
 */
class ProjectAssignees_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'project_assignees';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'status_id',
        'project_position_id',
        'urid',
    ];

}

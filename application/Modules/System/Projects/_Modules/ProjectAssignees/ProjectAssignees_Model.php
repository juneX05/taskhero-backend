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
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property int $status_id
 * @property int $project_position_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model whereProjectPositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectAssignees_Model whereUserId($value)
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

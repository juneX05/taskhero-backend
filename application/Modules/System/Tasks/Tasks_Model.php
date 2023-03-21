<?php

namespace Application\Modules\System\Tasks;

use Application\ApplicationBootstrapper;
use Application\Modules\BaseModel;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Priorities\Priorities_Model;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees_Model;
use Application\Modules\System\Tasks\Tasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Tasks\Tasks_Model
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $priority_id
 * @property int|null $project_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $task_status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereTaskStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereUrid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Users_Model> $assignees
 * @property-read int|null $assignees_count
 * @property-read Priorities_Model|null $priority
 * @mixin \Eloquent
 */
class Tasks_Model extends BaseModel
{
    use HasFactory;

    protected $table = Tasks::TABLE;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getFillable() {
        return ApplicationBootstrapper::setupFillables(Tasks::COLUMNS);
    }

    public function priority() {
        return $this->belongsTo(
            Priorities_Model::class
            , 'priority_id'
            , 'urid'
            , 'priority'
        );
    }

    public function assignees() {
        return $this->belongsToMany(
            Users_Model::class,
            TaskAssignees_Model::class,
            'task_id',
            'user_id',
            'id',
            'id'
        );
    }
}

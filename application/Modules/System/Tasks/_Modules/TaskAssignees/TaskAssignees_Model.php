<?php

namespace Application\Modules\System\Tasks\_Modules\TaskAssignees;

use Application\ApplicationBootstrapper;
use Application\Modules\BaseModel;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Tasks\_Modules\TaskAssignees\TaskAssignees;
use Application\Modules\System\Tasks\Tasks_Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Projects\_Modules\ProjectAssignees\TaskAssignees_Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model query()
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model whereUserId($value)
 * @property int $status_id
 * @method static \Illuminate\Database\Eloquent\Builder|TaskAssignees_Model whereStatusId($value)
 * @property-read Users_Model|null $user
 * @mixin \Eloquent
 */
class TaskAssignees_Model extends BaseModel
{
    use HasFactory;

    protected $table = TaskAssignees::TABLE;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getFillable() {
        return ApplicationBootstrapper::setupFillables(TaskAssignees::COLUMNS);
    }

    public function user() {
        return $this->belongsTo(Users_Model::class, 'user_id', 'id');
    }
}

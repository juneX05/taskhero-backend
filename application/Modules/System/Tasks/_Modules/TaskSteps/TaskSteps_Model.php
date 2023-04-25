<?php

namespace Application\Modules\System\Tasks\_Modules\TaskSteps;

use Application\ApplicationBootstrapper;
use Application\Modules\BaseModel;
use Application\Modules\Core\Media\Media_Model;
use Application\Modules\System\Files\Files_Model;
use Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Tasks\_Modules\TaskSteps\TaskSteps_Model
 *
 * @property int $id
 * @property int $task_id
 * @property string $title
 * @property string $description
 * @property int|null $completed
 * @property string|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskSteps_Model whereUrid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media_Model> $files
 * @property-read int|null $files_count
 * @mixin \Eloquent
 */
class TaskSteps_Model extends BaseModel
{
    use HasFactory;

    protected $table = TaskSteps::TABLE;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getFillable() {
        return ApplicationBootstrapper::setupFillables(TaskSteps::COLUMNS);
    }

    public function files() {
        return $this->hasManyThrough(
            Media_Model::class,
            Files_Model::class,
            'step_id', // Foreign key on the types table...
            'id', // Foreign key on the items table...
            'id', // Local key on the users table...
            'media_id' // Local key on the categories table...
        );
    }
}

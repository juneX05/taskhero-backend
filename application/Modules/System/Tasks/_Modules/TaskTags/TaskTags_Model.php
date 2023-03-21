<?php

namespace Application\Modules\System\Tasks\_Modules\TaskTags;

use Application\ApplicationBootstrapper;
use Application\Modules\BaseModel;
use Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Tasks\_Modules\TaskTags\TaskTags_Model
 *
 * @property int $id
 * @property int $task_id
 * @property int $tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTags_Model whereUrid($value)
 * @mixin \Eloquent
 */
class TaskTags_Model extends BaseModel
{
    use HasFactory;

    protected $table = TaskTags::TABLE;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getFillable() {
        return ApplicationBootstrapper::setupFillables(TaskTags::COLUMNS);
    }
}

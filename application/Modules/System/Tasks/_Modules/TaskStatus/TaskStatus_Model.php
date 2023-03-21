<?php

namespace Application\Modules\System\Tasks\_Modules\TaskStatus;

use Application\ApplicationBootstrapper;
use Application\Modules\BaseModel;
use Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Tasks\_Modules\TaskStatus\TaskStatus_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus_Model whereUrid($value)
 * @mixin \Eloquent
 */
class TaskStatus_Model extends BaseModel
{
    use HasFactory;

    protected $table = TaskStatus::TABLE;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getFillable() {
        return ApplicationBootstrapper::setupFillables(TaskStatus::COLUMNS);
    }
}

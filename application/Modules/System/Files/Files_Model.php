<?php

namespace Application\Modules\System\Files;

use Application\ApplicationBootstrapper;
use Application\Modules\BaseModel;
use Application\Modules\Core\Media\Media_Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Files\Files_Model
 *
 * @property int $id
 * @property int|null $project_id
 * @property int|null $task_id
 * @property int|null $step_id
 * @property int $media_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model whereStepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Files_Model whereUrid($value)
 * @mixin \Eloquent
 */
class Files_Model extends BaseModel
{
    use HasFactory;

    protected $table = Files::TABLE;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getFillable() {
        return ApplicationBootstrapper::setupFillables(Files::COLUMNS);
    }

    public function media() {
        return $this->belongsTo(
            Media_Model::class,
            'media_id'
            ,'id'
        );
    }
}

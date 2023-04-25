<?php

namespace Application\Modules\System\Projects\_Modules\ProjectBoards;

use Application\ApplicationBootstrapper;
use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Projects\_Modules\ProjectBoards\ProjectBoards_Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model query()
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectBoards_Model whereUrid($value)
 * @mixin \Eloquent
 */
class ProjectBoards_Model extends BaseModel
{
    use HasFactory;

    protected $table = ProjectBoards::TABLE;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getFillable() {
        return ApplicationBootstrapper::setupFillables(ProjectBoards::COLUMNS);
    }
}

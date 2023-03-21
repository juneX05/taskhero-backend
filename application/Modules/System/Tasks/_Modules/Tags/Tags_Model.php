<?php

namespace Application\Modules\System\Tasks\_Modules\Tags;

use Application\ApplicationBootstrapper;
use Application\Modules\BaseModel;
use Application\Modules\System\Tasks\_Modules\Tags\Tags;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Tasks\_Modules\Tags\Tags_Model
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Tags_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tags_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tags_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tags_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tags_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tags_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tags_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tags_Model whereUrid($value)
 * @mixin \Eloquent
 */
class Tags_Model extends BaseModel
{
    use HasFactory;

    protected $table = Tags::TABLE;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getFillable() {
        return ApplicationBootstrapper::setupFillables(Tags::COLUMNS);
    }
}

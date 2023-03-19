<?php

namespace Application\Modules\System\Projects\_Modules\ProjectCategories;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\System\Projects\_Modules\ProjectCategories\ProjectCategories_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectCategories_Model whereUrid($value)
 * @mixin \Eloquent
 */
class ProjectCategories_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'project_categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'title',
        'color',
        'urid',
    ];
}

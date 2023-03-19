<?php

namespace Application\Modules\Core\Modules\_Modules\ModuleTypes;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Modules\_Modules\ModuleTypes\ModuleTypes_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleTypes_Model whereUrid($value)
 * @mixin \Eloquent
 */
class ModuleTypes_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'module_types';
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

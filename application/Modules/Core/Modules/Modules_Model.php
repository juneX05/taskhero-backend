<?php

namespace Application\Modules\Core\Modules;


use Application\Modules\BaseModel;

/**
 * Application\Modules\Core\Modules\Modules_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property int $module_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereUrid($value)
 * @mixin \Eloquent
 * @property string $status_id
 * @method static \Illuminate\Database\Eloquent\Builder|Modules_Model whereStatusId($value)
 */
class Modules_Model extends BaseModel {
    protected $table = 'modules';

    protected $fillable = [
        'name',
        'title',
        'description',
        'status_id',
        'urid'
    ];
}

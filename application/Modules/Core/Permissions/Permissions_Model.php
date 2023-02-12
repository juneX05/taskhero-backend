<?php

namespace Application\Modules\Core\Permissions;

use Application\Modules\BaseModel;

/**
 * Application\Modules\Core\Permissions\Permissions_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property int $module_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions_Model whereUrid($value)
 * @mixin \Eloquent
 */
class Permissions_Model extends BaseModel {
    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'title',
        'description',
        'module_id',
        'urid'
    ];
}

<?php

namespace Application\Modules\Core\Roles;

use Application\Modules\BaseModel;

/**
 * Application\Modules\Core\Roles\Roles_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $color
 * @property int $user_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereUserId($value)
 * @property string|null $notes
 * @method static \Illuminate\Database\Eloquent\Builder|Roles_Model whereNotes($value)
 * @mixin \Eloquent
 */
class Roles_Model extends BaseModel {
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'title',
        'description',
        'color',
        'user_id',
        'status_id',
        'urid'
    ];
}

<?php

namespace Application\Modules\Core\Notifiers\_Modules\NotifierTypes;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Notifiers\_Modules\NotifierTypes\NotifierTypes_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifierTypes_Model whereUrid($value)
 * @mixin \Eloquent
 */
class NotifierTypes_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'notifier_types';
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

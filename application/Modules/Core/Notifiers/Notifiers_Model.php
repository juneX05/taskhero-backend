<?php

namespace Application\Modules\Core\Notifiers;


use Application\Modules\BaseModel;

/**
 * Application\Modules\Core\Notifiers\Notifiers_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $message
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifiers_Model whereUrid($value)
 * @mixin \Eloquent
 */
class Notifiers_Model extends BaseModel {
    protected $table = 'notifiers';

    protected $fillable = [
        'name',
        'title',
        'description',
        'message',
        'type',
        'status_id',
        'urid'
    ];
}

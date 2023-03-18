<?php

namespace Application\Modules\Core\Notifiers\_Modules\SentStatus;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Notifiers\_Modules\SentStatus\SentStatus_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentStatus_Model whereUrid($value)
 * @mixin \Eloquent
 */
class SentStatus_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'sent_status';
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

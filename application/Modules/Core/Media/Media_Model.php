<?php

namespace Application\Modules\Core\Media;

use Application\Modules\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Application\Modules\Core\Media\Media_Model
 *
 * @property int $id
 * @property string $name
 * @property string $original_name
 * @property string|null $description
 * @property string $extension
 * @property string $size
 * @property string $mime_type
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereUrid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media_Model whereUserId($value)
 * @mixin \Eloquent
 */
class Media_Model extends BaseModel
{
    use HasFactory;

    protected $table = 'media';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'original_name',
        'extension',
        'user_id',
        'description',
        'size',
        'mime_type',
        'urid',
    ];
}

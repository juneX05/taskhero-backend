<?php

namespace Application\Modules\System\Projects;


use Application\Modules\BaseModel;
use Application\Modules\Core\Media\Media_Model;
use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Priorities\Priorities;
use Application\Modules\System\Priorities\Priorities_Model;
use Application\Modules\System\Projects\_Modules\ProjectAssignees\ProjectAssignees_Model;
use Application\Modules\System\Projects\_Modules\ProjectCategories\ProjectCategories_Model;

/**
 * Application\Modules\System\Projects\Projects_Model
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $priority_id
 * @property int|null $media_id
 * @property int|null $project_category_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Users_Model> $assignees
 * @property-read int|null $assignees_count
 * @property-read ProjectCategories_Model|null $category
 * @property-read Media_Model|null $media
 * @property-read Priorities_Model|null $priority
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereProjectCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereUrid($value)
 * @mixin \Eloquent
 */
class Projects_Model extends BaseModel {
    protected $table = 'projects';

    protected $fillable = [
        'title',
        'description',
        'media_id',
        'priority_id',
        'project_category_id',
        'start_date',
        'end_date',
    ];

    public function category() {
        return $this->belongsTo(
            ProjectCategories_Model::class
            , 'project_category_id'
            , 'urid'
            , 'category'
        );
    }

    public function priority() {
        return $this->belongsTo(
            Priorities_Model::class
            , 'priority_id'
            , 'urid'
            , 'priority'
        );
    }

    public function assignees() {
        return $this->belongsToMany(
            Users_Model::class,
            ProjectAssignees_Model::class,
            'project_id', // Foreign key on users table...
            'user_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }

    public function media() {
        return $this->belongsTo(
            Media_Model::class
            , 'media_id'
            , 'urid'
            , 'media');
    }
}

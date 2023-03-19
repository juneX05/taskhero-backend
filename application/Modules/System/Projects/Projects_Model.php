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
 * Application\Modules\Core\Projects\Projects_Model
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $icon
 * @property string $link
 * @property int|null $parent
 * @property string $type
 * @property int $position
 * @property string $category
 * @property int $auth
 * @property int $sidebar_visibility
 * @property int $navbar_visibility
 * @property string|null $file_link
 * @property int|null $permission_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereAuth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereFileLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereNavbarVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereSidebarVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereUrid($value)
 * @property string|null $permission_name
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model wherePermissionName($value)
 * @property int|null $status_id
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereStatusId($value)
 * @property string $description
 * @property string $image
 * @property int $priority_id
 * @property int $category_id
 * @property string $start_date
 * @property string $end_date
 * @property string $assigned_users
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereAssignedUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereStartDate($value)
 * @property int $project_category_id
 * @method static \Illuminate\Database\Eloquent\Builder|Projects_Model whereProjectCategoryId($value)
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
            , 'id'
            , 'category'
        );
    }

    public function priority() {
        return $this->belongsTo(
            Priorities_Model::class
            , 'priority_id'
            , 'id'
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
            , 'id'
            , 'media');
    }
}

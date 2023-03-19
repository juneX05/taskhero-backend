<?php

namespace Application\Modules\System\Tasks;

use Application\Modules\BaseModel;

/**
 * Application\Modules\System\Tasks\Tasks_Model
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $assigned_users
 * @property int $priority_id
 * @property int|null $project_id
 * @property string|null $tags
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $task_status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $urid
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereAssignedUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereTaskStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tasks_Model whereUrid($value)
 * @mixin \Eloquent
 */
class Tasks_Model extends BaseModel {
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'assigned_users',
        'priority_id',
        'project_id',
        'tags',
        'start_date',
        'end_date',
        'task_status_id',
        'urid'
    ];
}

<?php

namespace Application\Modules\Core\Menus;


use Application\Modules\BaseModel;

/**
 * Application\Modules\Core\Menus\Menus_Model
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
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereAuth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereFileLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereNavbarVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereSidebarVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereUrid($value)
 * @mixin \Eloquent
 * @property string|null $permission_name
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model wherePermissionName($value)
 * @property int|null $status_id
 * @method static \Illuminate\Database\Eloquent\Builder|Menus_Model whereStatusId($value)
 */
class Menus_Model extends BaseModel {
    protected $table = 'menus';

    protected $fillable = [
        'name',
        'title',
        'icon',
        'link',
        'parent',
        'urid',
        'type',
        'position',
        'category',
        'auth',
        'sidebar_visibility',
        'navbar_visibility',
        'file_link',
        'permission_name',
        'status_id',
    ];
}

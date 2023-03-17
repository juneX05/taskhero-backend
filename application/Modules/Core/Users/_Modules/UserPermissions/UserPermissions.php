<?php

namespace Application\Modules\Core\Users\_Modules\UserPermissions;

use Application\Modules\Core\Permissions\Permissions_Model;

class UserPermissions
{
    public static function permissionsList($user_id) {
        $user_permissions = getUserPermissions($user_id);

        $permission_ids_given = Permissions_Model
            ::whereIn('name',  $user_permissions)
            ->pluck('permissions.id')
            ->toArray();

        $permission_ids_denied = Permissions_Model
            ::whereNotIn('name',  $user_permissions)
            ->pluck('permissions.id')
            ->toArray();

        $permissions = [];

        foreach ($permission_ids_given as $permission) {
            $permissions[$permission] = 'granted';
        }

        foreach ($permission_ids_denied as $permission) {
            $permissions[$permission] = 'denied';
        }

        asort($permissions);

        return $permissions;
    }
}

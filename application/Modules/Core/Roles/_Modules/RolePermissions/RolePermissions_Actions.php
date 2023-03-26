<?php


namespace Application\Modules\Core\Roles\_Modules\RolePermissions;

use Application\Modules\Core\Permissions\Permissions_Model;
use Exception;
use Illuminate\Database\Eloquent\Model;

class RolePermissions_Actions
{
    private static $ACTOR = 'RolePermissions';

    public static function saveRolePermission($data) {
        try {
            $item = RolePermissions_Model::create($data);

            if (!$item) {
                return ['status' => false];
            }

            return ['status' => true, 'data' => $item];
        } catch (Exception $exception) {
            return ['status' => false];
        }
    }


    public static function permissionsList($role_id) {

        $all_permissions_id = Permissions_Model::all()->pluck('id');

        $roles_permissions = RolePermissions_Model::whereIn('role_id', [$role_id])
            ->join('permissions', 'role_permissions.permission_id','=', 'permissions.id')
            ->distinct()
            ->pluck('role_permissions.status_id','permissions.id')
            ->toArray();

        $permissions = [];

        foreach ($all_permissions_id as $permission_id) {
            if (isset($roles_permissions[$permission_id])) {
                if ($roles_permissions[$permission_id] == 1){
                    $status = 'given';
                } else {
                    $status = 'denied';
                }
            } else {
                $status = 'not_given';
            }
            $permissions[$permission_id] = $status;
        }

        return $permissions;
    }

    public static function batchUpdateOrSavePermissions($role, $permissions) {
        try {
            $role_permissions = self::permissionsList($role->id);
            $new_permissions = $permissions + $role_permissions;

            $difference = array_diff_assoc($new_permissions,$role_permissions);

            $old_data = $role_permissions;

            foreach ($difference as $id => $status) {
                $status_id = $status == 'given' ? 1 : 2;
                $permission_id = $id;
                if ($status == 'given' || $status == 'denied') {

                    $result = RolePermissions_Model
                        ::updateOrCreate([
                            'role_id' => $role->id,
                            'permission_id' => $permission_id
                        ],[
                            'status_id' => $status_id
                        ]);
                } else {
                    $result = RolePermissions_Model
                        ::where([
                            'permission_id' => $permission_id,
                            'role_id' => $role->id,
                        ])->delete();
                }

                if (!$result) {
                    return [
                        'status' => false,
                        'message' => 'Failed to process data:'
                            . json_encode([
                                'role_id' => $role->id,
                                'permission_id' => $permission_id,
                                'status_id' => $status_id
                            ])
                    ];
                }
            }

            $new_data = $difference;

            logInfo(__FUNCTION__,[
                'actor_id' => $role->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update or Create Role Permission',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($new_data),
            ],'UPDATE-ROLE_PERMISSION');

            return ['status' => true, 'data' => []];
        } catch (Exception $exception) {
            return ['status' => false, 'error' => $exception->getMessage()];
        }
    }

}

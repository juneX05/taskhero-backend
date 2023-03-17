<?php


namespace Application\Modules\Core\Users\_Modules\UserPermissions;

use Application\Modules\Core\Permissions\Permissions_Model;
use Application\Modules\Core\Roles\_Modules\RolePermissions\RolePermissions_Model;
use Application\Modules\Core\Users\_Modules\UserRoles\UserRoles_Model;
use Exception;
use Illuminate\Database\Eloquent\Model;

class UserPermissions_Actions
{
    private static $ACTOR = 'UserPermissions';

    public static function saveUserPermission($data) {
        try {
            $item = UserPermissions_Model::create($data);

            if (!$item) {
                return ['status' => false];
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $item->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save User Permission',
                'old_data' => null,
                'new_data' => json_encode($item),
            ],'SAVE-USER_PERMISSION');

            return ['status' => true, 'data' => $item];
        } catch (Exception $exception) {
            return ['status' => false];
        }
    }

    public static function permissionsList($user_id) {

        $all_permissions_id = Permissions_Model::all()->pluck('id');

        $user_roles_data = UserRoles_Model::whereUserId($user_id)
            ->whereStatusId(1)
            ->pluck('role_id')->toArray();

        $roles_permissions = RolePermissions_Model::whereIn('role_id', $user_roles_data)
            ->join('permissions', 'role_permissions.permission_id','=', 'permissions.id')
            ->distinct()
            ->pluck('role_permissions.status_id','permissions.id')
            ->toArray();

        $users_assigned_permissions = UserPermissions_Model::whereUserId($user_id)
            ->join('permissions', 'user_permissions.permission_id','=', 'permissions.id')
            ->distinct()
            ->pluck('user_permissions.status_id','permissions.id')
            ->toArray();

        $user_permissions = array_merge_recursive_distinct($roles_permissions, $users_assigned_permissions);

        $permissions = [];

        foreach ($all_permissions_id as $permission_id) {
            if (isset($user_permissions[$permission_id])) {
                if ($user_permissions[$permission_id] == 1){
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

    public static function batchUpdateOrSavePermissions($user, $permissions) {
        try {
            $user_permissions = self::permissionsList($user->id);
            $new_permissions = $permissions + $user_permissions;

            $difference = array_diff_assoc($new_permissions,$user_permissions);

            $old_data = $user_permissions;

            foreach ($difference as $id => $status) {
                $status_id = $status == 'given' ? 1 : 2;
                $permission_id = $id;
                if ($status == 'given' || $status == 'denied') {

                    $result = UserPermissions_Model
                        ::updateOrCreate([
                            'user_id' => $user->id,
                            'permission_id' => $permission_id
                        ],[
                            'status_id' => $status_id
                        ]);
                } else {
                    $result = UserPermissions_Model
                        ::where([
                            'permission_id' => $permission_id,
                            'user_id' => $user->id,
                        ])->delete();
                }

                if (!$result) {
                    return [
                        'status' => false,
                        'message' => 'Failed to process data:'
                            . json_encode([
                                'user_id' => $user->id,
                                'permission_id' => $permission_id,
                                'status_id' => $status_id
                            ])
                    ];
                }
            }

            $new_data = $difference;

            logInfo(__FUNCTION__,[
                'actor_id' => $user->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update or Create User Permission',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($new_data),
            ],'SAVE-USER_PERMISSION');

            return ['status' => true, 'data' => []];
        } catch (Exception $exception) {
            return ['status' => false];
        }
    }

}

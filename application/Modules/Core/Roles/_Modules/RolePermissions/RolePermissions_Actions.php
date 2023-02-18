<?php


namespace Application\Modules\Core\Roles\_Modules\RolePermissions;

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

            logInfo(__FUNCTION__,[
                'actor_id' => $item->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Role Permission',
                'old_data' => null,
                'new_data' => json_encode($item),
            ],'SAVE-ROLE_PERMISSION');

            return ['status' => true, 'data' => $item];
        } catch (Exception $exception) {
            return ['status' => false];
        }
    }

    private static function rolePermissions($role_id) {
        return RolePermissions_Model
            ::whereRoleId($role_id)
            ->join('permissions', 'permissions.id', 'role_permissions.permission_id')
            ->where('status_id', 1)
            ->get([
                'permissions.title'
            ])
            ->toArray();
    }

    public static function batchUpdateOrSavePermissions($role, $permissions) {
        try {
            $old_data = self::rolePermissions($role->id);

            foreach ($permissions as $record) {
                $status_id = $record['selected'] == true ? 1 : 2;
                $permission_id = $record['id'];

                $result = RolePermissions_Model
                    ::updateOrCreate([
                        'role_id' => $role->id,
                        'permission_id' => $permission_id
                    ],[
                        'status_id' => $status_id
                    ]);

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

            $new_data = self::rolePermissions($role->id);

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

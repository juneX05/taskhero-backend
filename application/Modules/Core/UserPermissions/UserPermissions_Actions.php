<?php


namespace Application\Modules\Core\UserPermissions;

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

    private static function userPermissions($user_id) {
        return UserPermissions_Model
            ::whereUserId($user_id)
            ->join('permissions', 'permissions.id', 'user_permissions.permission_id')
            ->where('status_id', 1)
            ->get([
                'permissions.title'
            ])
            ->toArray();
    }

    public static function batchUpdateOrSavePermissions($user, $permissions) {
        try {
            $old_data = self::userPermissions($user->id);

            foreach ($permissions as $record) {
                $status_id = $record['selected'] == true ? 1 : 2;
                $permission_id = $record['id'];

                $result = UserPermissions_Model
                    ::updateOrCreate([
                        'user_id' => $user->id,
                        'permission_id' => $permission_id
                    ],[
                        'status_id' => $status_id
                    ]);

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

            $new_data = self::userPermissions($user->id);

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

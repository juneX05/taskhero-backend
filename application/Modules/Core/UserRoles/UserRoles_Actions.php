<?php


namespace Application\Modules\Core\UserRoles;


class UserRoles_Actions
{

    private static $ACTOR = 'UserRoles';

    private static function userRoles($user_id) {
        return UserRoles_Model
            ::where('user_roles.user_id',$user_id)
            ->join('roles', 'roles.id', 'user_roles.role_id')
            ->where('user_roles.status_id', 1)
            ->get([
                'roles.title'
            ])
            ->toArray();
    }

    public static function batchUpdateOrSaveRoles($user, $roles) {
        try {
            $old_data = self::userRoles($user->id);

            foreach ($roles as $record) {
                $status_id = $record['selected'] == true ? 1 : 2;
                $role_id = $record['id'];

                $result = UserRoles_Model
                    ::updateOrCreate([
                        'user_id' => $user->id,
                        'role_id' => $role_id
                    ],[
                        'status_id' => $status_id
                    ]);

                if (!$result) {
                    return [
                        'status' => false,
                        'message' => 'Failed to process data:'
                            . json_encode([
                                'user_id' => $user->id,
                                'role_id' => $role_id,
                                'status_id' => $status_id
                            ])
                    ];
                }
            }

            $new_data = self::userRoles($user->id);

            logInfo(__FUNCTION__,[
                'actor_id' => $user->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update or Create User Roles',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($new_data),
            ],'UPDATE_CREATE-USER_ROLES');

            return ['status' => true, 'data' => []];
        } catch (\Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }
}

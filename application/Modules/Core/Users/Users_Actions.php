<?php


namespace Application\Modules\Core\Users;


use Application\Modules\Core\Logs\Logs_Actions;
use Application\Modules\Core\Permissions\_Modules\PermissionStatus\PermissionStatus;
use Application\Modules\Core\Permissions\_Modules\PermissionStatus\PermissionStatus_Model;
use Application\Modules\Core\Permissions\Permissions_Model;
use Application\Modules\Core\Roles\Roles_Model;
use Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions;
use Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions_Actions;
use Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions_Model;
use Application\Modules\Core\Users\_Modules\UserRoles\UserRoles_Actions;
use Application\Modules\Core\Users\_Modules\UserRoles\UserRoles_Model;
use Application\Modules\Core\Users\_Modules\UserStatus\UserStatus;
use Application\Modules\Core\Users\_Modules\UserStatus\UserStatus_Model;
use Application\Modules\Core\Users\_Modules\UserTypes\UserTypes_Model;
use Application\Modules\ProfileManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Monolog\Handler\IFTTTHandler;

class Users_Actions
{
    private static $ACTOR = 'Users';

    public static function index() {
        if (denied('view_users')) return error('Forbidden', 500);

        try {
            $all_data = Users_Model
                ::join('user_types', 'user_types.id', 'users.user_type_id')
                ->leftJoin('users as creator', 'creator.id', 'users.created_by')
                ->join('user_status','user_status.id', 'users.user_status_id')
                ->orderBy('users.id')
                ->get([
                    'users.*',
                    'creator.name as created_by',
                    'user_types.title as user_type',
                    'user_types.color as user_type_color',
                    'user_status.name as status',
                    'user_status.color as status_color',
                ]);

            return success('Success', $all_data);
        } catch (\Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function getUserProfile(){

        $record = Users_Model::whereId(Auth::id())->first();
        if (!$record) return error('Record Not Found', 404);

        $result = ProfileManager::fetch($record);

        if ($result['status']) {
            return success('Success', $result['data']);
        }

        return error('Failed to get user profile.', 500);
    }

    public static function splash() {
        if (denied('view_users')) return error('Forbidden', 500);

        try {
            $data = [];
            $data['user_types'] = UserTypes_Model::all();
            $data['user_status'] = UserStatus_Model::all();
            $data['roles'] = Roles_Model::all();

            return success('Success', $data);
        } catch (\Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function viewUser($urid) {
        if (denied('view_user')) return error('Forbidden', 500);

        try {
            $record = Users_Model
                ::join('user_types', 'user_types.id', 'users.user_type_id')
                ->join('user_status','user_status.id', 'users.user_status_id')
                ->where('users.urid', $urid)
                ->first([
                    'users.*',
                    'user_types.title as user_type',
                    'user_types.color as user_type_color',
                    'user_types.urid as user_type_id',
                    'user_status.name as status',
                    'user_status.color as status_color',
                    'user_status.urid as user_status_id',
                ]);

            if (!$record) return error('Record not found', 404);

            $item = [];
            $item['user'] = $record;
            $item['roles'] = UserRoles_Model
                ::join('roles','roles.id','user_roles.role_id')
                ->where('user_roles.user_id' , $record->id)
                ->where('user_roles.status_id' , 1)
                ->get([
                    'roles.*',
                    'user_roles.id as user_role_id'
                ]);

            $item['permissions'] = Permissions_Model
                ::whereIn('name',  getUserPermissions($record->id))
                ->get();

            $item['permission_status'] = PermissionStatus_Model::get();

            return success('Success.', $item);
        } catch (\Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function changeUserPassword($request_data) {
        if (denied('change_user_password')) return error('Forbidden', 500);

        try {
            $validation = validateData($request_data, [
                'user_id' => ['required'],
                'password' => ['required'],
                'password_confirmation' => ['required','same:password'],
            ]);

            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            $model = Users_Model::whereUrid($data['user_id'])->first();
            $user_main_developer = Auth::id() == 1; //Main Developer Account

            if (!$user_main_developer && $model->id == 1) {
                return error('You are not allowed.', 403);
            }

            $updated = $model->update(['password' => bcrypt($data['password'])]);

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Change User Password',
                'old_data' => json_encode([]),
                'new_data' => json_encode([]),
            ],'CHANGE-USER-PASSWORD');

            return success('Success.', []);

        } catch (\Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function changePassword($request_data) {
        try {
            $validation = validateData($request_data, [
                'old_password' => ['required'],
                'password' => ['required'],
                'password_confirmation' => ['required','same:password'],
            ]);

            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            $model = Users_Model::whereId(Auth::id())->first();

            $password_check = Hash::check($data['old_password'], $model->password);

            if ($password_check){
                $update = $model->update([
                    'password' =>  bcrypt($data['password'])
                ]);

                if ($update) {
                    logInfo(__FUNCTION__,[
                        'actor_id' => $model->urid,
                        'actor' => self::$ACTOR,
                        'action_description' => 'Change Password',
                        'old_data' => json_encode([]),
                        'new_data' => json_encode([]),
                    ],'CHANGE-PASSWORD');

                    return success('Success.', []);
                }

                return error('Failed to change password', 500);

            }

            return error('Old Passwords do not match.', 500);
        } catch (\Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function changeUserPermissions($request_data, $urid) {
        if (denied('change_user_permissions')) return error('Forbidden', 500);

        try {
            $user = Users_Model
                ::whereUrid($urid)
                ->first();
            if (!$user) {
                return error('User not found.', 404);
            }

            $validation = validateData($request_data, [
                'permissions' => ['required', 'array'],
            ]);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            if (Auth::id() != Users::ADMINISTRATOR_ACCOUNT_ID && $user->id == Users::ADMINISTRATOR_ACCOUNT_ID) {
                return error('You are not allowed.', 403);
            }

            $result = UserPermissions_Actions::batchUpdateOrSavePermissions($user, $data['permissions']);

            if (!$result['status']) {
                return error($result['message'], 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $user->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Change User Permission',
                'old_data' => json_encode([]),
                'new_data' => json_encode([]),
            ],'CHANGE-USER_PERMISSIONS');

            return ['status' => true, 'data' => []];
        } catch (\Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function changeUserRoles($request_data, $urid) {
        if (denied('change_user_roles')) return error('Forbidden', 500);

        try {
            $user = Users_Model
                ::whereUrid($urid)
                ->first();
            if (!$user) {
                return error('User not found', 404);
            }

            $validation = validateData($request_data, [
                'roles' => ['required', 'array'],
            ]);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            if (Auth::id() != 1 && $user->id == 1) {
                return error('You are not allowed.', 403);
            }

            $result = UserRoles_Actions::batchUpdateOrSaveRoles($user, $data['roles']);

            if (!$result['status']) {
                return error($result['message'], 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $user->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Change User Roles',
                'old_data' => json_encode([]),
                'new_data' => json_encode([]),
            ],'CHANGE-USER_ROLES');

            return success('Success', []);
        } catch (\Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function saveUser($request_data) {
        if(denied('save_user')) return error('Forbidden', 403);

        DB::beginTransaction();

        $result = self::processUserRegistration($request_data);
        if ($result['status'] == false ) {
            if (isset($result['message']) && $result['message'] == 'validation_error') {
                return sendValidationError($result['error']);
            } else {
                return error($result['error'], 500);
            }
        }

        DB::commit();
        return success('User created successfully', $result['data']);
    }

    public static function updateUserAccountDetails($request_data, $urid) {
        if(denied('update_user')) return error('Forbidden', 403);

        DB::beginTransaction();

        $result = self::processUserUpdateAccountDetails($request_data, $urid);
        if ($result['status'] == false ) {
            if (isset($result['message']) && $result['message'] == 'validation_error') {
                return sendValidationError($result['error']);
            } else {
                return error($result['error'], 500);
            }
        }

        DB::commit();
        return success('User updated successfully', $result['data']);
    }

    public static function processUserRegistration($request_data) {
        try {

            $validation = validateData($request_data, [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'user_type_id' => 'required|string',
                'password' => 'required',
                'password_confirmation' => 'required|same:password',
                'role_id' => 'required|string',
            ],[
                'user_type_id.required' => 'User Type is required',
                'user_type_id.string' => 'User Type is required',
                'role_id.required' => 'Role is required',
                'role_id.string' => 'Role is required',
            ]);

            if (!$validation['status'])
                return ['status' => false, 'message' => 'validation_error', 'error' => $validation['error']];

            $data = $validation['data'];
            $data['user_status_id'] = UserStatus::PENDING; //PENDING USER
            $data['password'] = bcrypt($data['password']);

            $record = Users_Model::create($data);

            if(!$record) return ['status' => false,'error' => 'Failed to save user'];

            $item = UserRoles_Model::create([
                'user_id' => $record->id, 'role_id' => $data['role_id']
            ]);

            if (!$item) return ['status' => false, 'error' => 'Failed to save user role'];

            logInfo(__FUNCTION__,[
                'actor' => self::$ACTOR,
                'actor_id' => $record->urid,
                'action_description' => 'New User Registered',
                'old_data' => null,
                'new_data' => json_encode($record),
            ],'USER-REGISTRATION');

            return ['status' => true, 'data' => $record];

        } catch (\Exception $exception) {
            return ['status' => false, 'error' => $exception->getMessage()];
        }
    }

    public static function processUserUpdateAccountDetails($request_data, $urid) {
        try {
            $record = Users_Model::whereUrid($urid)->first();
            if (!$record) return ['status' => false, 'error' => 'User not found'];

            $validation = validateData($request_data, [
                'name' => 'required',
                'email' => ['required','email', Rule::unique('users')->ignore($record->id)],
                'user_type_id' => 'required|string',
            ],[
                'user_type_id.required' => 'User Type is required',
                'user_type_id.string' => 'User Type is required',
            ]);

            if (!$validation['status'])
                return ['status' => false, 'message' => 'validation_error', 'error' => $validation['error']];

            $data = $validation['data'];

            $user_types = UserTypes_Model::all()->pluck('id','urid');

            $data['user_type_id'] = $user_types[$data['user_type_id']];
            $old_data = $record->toArray();

            $update = $record->update($data);

            if(!$update) return ['status' => false,'error' => 'Failed to update account details'];

            logInfo(__FUNCTION__,[
                'actor' => self::$ACTOR,
                'actor_id' => $record->urid,
                'action_description' => 'User Account Details Updated',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record),
            ],'USER-ACCOUNT-DETAILS-UPDATE');

            return ['status' => true, 'data' => $record];

        } catch (\Exception $exception) {
            return ['status' => false, 'error' => $exception->getMessage()];
        }
    }

    public static function processChangeUserStatus($request_data, $urid) {
        try{
            $record = Users_Model::whereUrid($urid)->first();
            if (!$record) return error('Record Not Found', 404);

            $validation = validateData($request_data, [
                'user_status_id' => ['required','integer'],
            ]);
            if (!$validation['status']) return ['status' => false, 'message' => 'validation_error', 'error' => $validation['error']];

            $data = $validation['data'];

            $update = $record->update($data);

            if ($update) {
                logInfo(__FUNCTION__,[
                    'actor' => self::$ACTOR,
                    'actor_id' => $urid,
                    'action_description' => 'User Status Updated',
                    'old_data' => null,
                    'new_data' => json_encode($data),
                ],'USER-STATUS-UPDATED');

                return ['status' => true];
            }

            return ['status' => false, 'error' => 'User Status Update Failed'];
        } catch (\Exception $exception) {
            return ['status' => false, 'error' => $exception->getMessage()];
        }
    }

    public static function updateUserProfile($request_data){

        $record = Users_Model::whereId(Auth::id())->first();
        if (!$record) return error('Record Not Found', 404);

        $old_data = $record->toArray();

        $result = ProfileManager::update($record, $request_data);

        if ($result['status']) {
            logInfo(__FUNCTION__,[
                'actor' => self::$ACTOR,
                'actor_id' => $record->urid,
                'action_description' => 'User Profile Updated',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($request_data),
            ],'USER-PROFILE-UPDATED');

            return success('Success');
        }

        return error('Failed to get user profile.', 500);
    }

    public static function completeUserRegistration($urid){
        if (denied('complete_user_registration')) return error('Forbidden', 500);

        $record = Users_Model::whereUrid($urid)->first();
        if (!$record) return error('User not found', 404);

        if ($record->user_status_id != UserStatus::PENDING) {
            return error('User is not pending', 409);
        }

        $old_data = $record->toArray();

//        $validation = validateData($request_data, [
//            'role_id' => 'required|integer',
//            'user_type_id' => 'required|integer'
//        ]);
//
//        if (!$validation['status']) return ['status' => false, 'message' => 'validation_error', 'error' => $validation['error']];

//        $data = $request_data;
        $data['user_status_id'] = UserStatus::ACTIVE;

//        DB::beginTransaction();

        //Update Username, email and user_type
        $user_update = $record->update($data);
        if (!$user_update) return error('Failed to Update User', 500);

        //Update user role
//        $user_role_update = UserRoles_Actions::batchUpdateOrSaveRoles($record, [
//           [ 'id' => $data['role_id'], 'selected' => true,]
//        ]);
//
//        if (!$user_role_update['status'])
//            return error($user_role_update['message'], 500);

        logInfo(__FUNCTION__,[
            'actor' => self::$ACTOR,
            'actor_id' => $record->urid,
            'action_description' => 'User Registration Completed',
            'old_data' => json_encode($old_data),
            'new_data' => json_encode($record),
        ],'USER-REGISTRATION-COMPLETED');

//        DB::commit();

        return success('User Registration Complete.');
    }

    public static function deactivateUser($request_data, $urid){
        if (denied('deactivate_user')) return error('Forbidden', 500);

        $record = Users_Model::whereUrid($urid)->first();
        if (!$record) return error('User not found', 404);

        if ($record->user_status_id != UserStatus::ACTIVE) {
            return error('User is not Active', 409);
        }

        $old_data = $record->toArray();

        $validation = validateData($request_data, [
            'reason' => ['required','string'],
        ]);

        if (!$validation['status']) return ['status' => false, 'message' => 'validation_error', 'error' => $validation['error']];

        $data = $validation['data'];

        $data['user_status_id'] = UserStatus::INACTIVE;
        $data['notes'] = $data['reason'];

        $user_update = $record->update($data);
        if (!$user_update) return error('Failed to Deactivate User', 500);

        logInfo(__FUNCTION__,[
            'actor' => self::$ACTOR,
            'actor_id' => $record->urid,
            'action_description' => 'User Deactivated',
            'old_data' => json_encode($old_data),
            'new_data' => json_encode([]),
        ],'USER-DEACTIVATED');

        return success('User Deactivated.');
    }

    public static function activateUser($request_data, $urid){
        if (denied('activate_user')) return error('Forbidden', 500);

        $record = Users_Model::whereUrid($urid)->first();
        if (!$record) return error('User not found', 404);

        if ($record->user_status_id != UserStatus::INACTIVE) {
            return error('User is not inactive', 409);
        }

        $old_data = $record->toArray();

        $validation = validateData($request_data, [
            'reason' => ['required','string'],
        ]);

        if (!$validation['status']) return ['status' => false, 'message' => 'validation_error', 'error' => $validation['error']];

        $data = $validation['data'];

        $data['user_status_id'] = UserStatus::ACTIVE;
        $data['notes'] = $data['reason'];

        $user_update = $record->update($data);
        if (!$user_update) return error('Failed to Activate User', 500);

        logInfo(__FUNCTION__,[
            'actor' => self::$ACTOR,
            'actor_id' => $record->urid,
            'action_description' => 'User Activated',
            'old_data' => json_encode($old_data),
            'new_data' => json_encode([]),
        ],'USER-ACTIVATED');

        return success('User Activated.');
    }

    public static function getUserPermissions($urid) {
        if (denied('view_user')) return error('Forbidden', 500);

        $record = Users_Model::whereUrid($urid)->first();
        if (!$record) return error('User not found', 404);

        $user_permissions = UserPermissions_Model
            ::where('user_id', $record->id)
            ->join('status', 'user_permissions.status_id', '=', 'status.id')
            ->join('permissions', 'user_permissions.permission_id','=', 'permissions.id')
            ->get([
                'permissions.id as id',
                'user_permissions.status_id as status'
            ]);

        $permissions = Permissions_Model::all();

        return success('User Permissions', [
            'user_permissions' => $user_permissions,
            'all_permissions' => $permissions,
        ]);
    }
}

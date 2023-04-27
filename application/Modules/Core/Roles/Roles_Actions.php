<?php


namespace Application\Modules\Core\Roles;


use Application\Modules\Core\Permissions\Permissions_Model;
use Application\Modules\Core\Roles\_Modules\RolePermissions\RolePermissions_Actions;
use Application\Modules\Core\Roles\_Modules\RolePermissions\RolePermissions_Model;
use Application\Modules\Core\Status\Status;
use Application\Modules\Core\Status\Status_Model;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Roles_Actions
{
    private static $ACTOR = 'Roles';

    public static function index() {
        if (denied('view_roles')) return error('Forbidden', 500);

        try {
            $all_data = Roles_Model
                ::join('status', 'status.id', 'roles.status_id')
                ->select(['roles.*', 'status.name as status', 'status.color as status_color'])
                ->get();

            return success('Success', $all_data);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function viewRole($urid) {
        if (denied('view_role')) return error('Forbidden', 500);

        try {
            $record = Roles_Model
                ::join('status', 'status.id', 'roles.status_id')
                ->where('roles.urid',$urid)
                ->select(['roles.*', 'status.name as status', 'status.color as status_color'])
                ->first();
            if (!$record) {
                return error('Record Not found', 404);
            }

            $permissions = RolePermissions_Model
                ::join('permissions', 'permissions.id','role_permissions.permission_id')
                ->where('role_permissions.role_id',$record->id)
                ->where('role_permissions.status_id',1)
                ->get();

            $all_data['role'] = $record;
            $all_data['permissions'] = $permissions;

            return success('Success', $all_data);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private static function validate($data, $record = null) {
        $rules = [
            'name' => ['required','string'],
            'title' => ['required','string'],
            'description' => ['required','string'],
        ];

        if ($record == null) {
            $rules['name'][] = Rule::unique('roles');
            $rules['title'][] = Rule::unique('roles');
        } else {
            $rules['name'][] = Rule::unique('roles')->ignore($record->id);
            $rules['title'][] = Rule::unique('roles')->ignore($record->id);
        }
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) return [
            'status' => false,
            'errors' => $validator->errors()
        ];

        return ['status' => true, 'data' => $validator->validated()];
    }

    public static function saveRole($request_data) {
        if (denied('save_role')) return error('Forbidden', 500);

        try {
            $validation = self::validate($request_data);
            if (!$validation['status']) return $validation;

            $data = $validation['data'];
            $data['user_id'] = request()->user()->id;
            $model = Roles_Model::create($data);

            if(!$model) {
                return error('Record not found', 404);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Role',
                'old_data' => json_encode([]),
                'new_data' => json_encode($model->toArray()),
            ],'SAVE-ROLE');

            return success('Success', $model);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function updateRole($request_data, $urid) {
        if (denied('update_role')) return error('Forbidden', 500);

        try {
            $record = Roles_Model::whereUrid($urid)->first();
            if (!$record) error('Record Not Found', 404);

            $validation = self::validate($request_data, $record);
            if (!$validation['status']) return $validation;

            $data = $validation['data'];
            $old_data = $record;
            $updated = $record->update($data);

            if(!$updated) {
                return error('Failed to update record', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update Role',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record->toArray()),
            ],'SAVE-ROLE');

            return success('Success', $record);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function changeRolePermissions($request_data, $urid) {
        if (denied('change_role_permissions')) return error('Forbidden', 500);

        try {
            $validation = validateData($request_data, [
                'permissions' => ['required', 'array'],
            ]);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            $role = Roles_Model
                ::whereUrid($urid)
                ->first();
            if (!$role) {
                return error('Role not found.', 404);
            }

            if (Auth::id() != 1 && $role->id == 1) {
                return error('You are not allowed.', 403);
            }

            $result = RolePermissions_Actions::batchUpdateOrSavePermissions($role, $data['permissions']);

            if (!$result['status']) {
                return error($result['error'], 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $role->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Change Role Permission',
                'old_data' => json_encode([]),
                'new_data' => json_encode([]),
            ],'CHANGE-ROLE_PERMISSIONS');

            return ['status' => true, 'data' => []];
        } catch (\Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function getRoleStatuses() {
        if (denied('change_role_status')) return error('Forbidden', 403);

        try {
            $item = Status_Model::all();

            return success('Success', $item);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function activateRole($request_data, $urid) {
        if (denied('change_role_status')) return error('Forbidden', 500);

        try {
            $record = Roles_Model::whereUrid($urid)->first();
            if (!$record) error('Record Not Found', 404);

            if (Auth::id() != 1 && $record->id == 1) {
                return error('You are not allowed.', 403);
            }

            $validation = validateData($request_data, [
                'reason' => ['required']
            ]);
            if (!$validation['status']) return $validation;

            $data = $validation['data'];

            $old_data = $record;
            $updated = $record->update([
                'status_id' => Status::ACTIVE,
                'notes' => $data['reason']
            ]);

            if(!$updated) {
                return error('Failed to change role status', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Activate Role',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record->toArray()),
            ],'ACTIVATE-ROLE');

            return success('Success', $record);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function deactivateRole($request_data, $urid) {
        if (denied('change_role_status')) return error('Forbidden', 500);

        try {
            $record = Roles_Model::whereUrid($urid)->first();
            if (!$record) error('Record Not Found', 404);

            if (Auth::id() != 1 && $record->id == 1) {
                return error('You are not allowed.', 403);
            }

            $validation = validateData($request_data, [
                'reason' => ['required']
            ]);
            if (!$validation['status']) return $validation;

            $data = $validation['data'];

            $old_data = $record;
            $updated = $record->update([
                'status_id' => Status::INACTIVE,
                'notes' => $data['reason']
            ]);

            if(!$updated) {
                return error('Failed to change role status', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Deactivate Role',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record->toArray()),
            ],'DEACTIVATE-ROLE');

            return success('Success', $record);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function getRolePermissions($urid) {
        if (denied('view_role')) return error('Forbidden', 500);

        $record = Roles_Model::whereUrid($urid)->first();
        if (!$record) return error('Role not found', 404);

        $role_permissions = RolePermissions_Model
            ::where('role_id', $record->id)
            ->join('status', 'role_permissions.status_id', '=', 'status.id')
            ->join('permissions', 'role_permissions.permission_id','=', 'permissions.id')
            ->get([
                'permissions.id as id',
                'role_permissions.status_id as status'
            ]);

        $permissions = Permissions_Model::all();

        return success('Role Permissions', [
            'role_permissions' => $role_permissions,
            'all_permissions' => $permissions,
        ]);
    }

}

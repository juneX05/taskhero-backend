<?php


namespace Application\Modules\Core\Permissions;

use Application\Modules\Core\Roles\_Modules\RolePermissions\RolePermissions_Actions;
use Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions_Actions;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Permissions_Actions
{
    private static $ACTOR = 'Permissions';

    public static function index() {
        if (denied('view_permissions')) return error('Forbidden', 403);
        try {
            $all_data = Permissions_Model
                ::leftJoin('modules','permissions.module_id','=', 'modules.id')
                ->get(['permissions.*','modules.name as module', 'modules.title as module_title']);

            return success('Success', $all_data);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function validate($data, $record = null) {
        $rules=[
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'module_id' => ['required', 'string'],
        ];

        if ($record == null) {
            $rules['name'][] = Rule::unique('permissions');
            $rules['title'][] = Rule::unique('permissions');
        } else {
            $rules['name'][] = Rule::unique('permissions')->ignore($record->id);
            $rules['title'][] = Rule::unique('permissions')->ignore($record->id);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()];
        }

        $data = $validator->validated();
        return ['status' => true, 'data' => $data];

    }

    public static function _createPermission($data) {
        $item = Permissions_Model::create($data);

        if (!$item) {
            return error('Failed to save permission', 500);
        }

        RolePermissions_Actions::saveRolePermission([
            'role_id' => 1,
            'permission_id' => $item->id,
            'status_id' => 1
        ]);

        return $item;
    }

    public static function savePermission($request_data) {
        if (denied('save_permission')) return error('Forbidden', 403);

        try {
            $validation = self::validate($request_data);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            $item = self::_createPermission($data);

            logInfo(__FUNCTION__,[
                'actor_id' => $item->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Permission',
                'old_data' => null,
                'new_data' => json_encode($item),
            ],'SAVE-PERMISSION');

            return success('Success', $item);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function updatePermission($request_data) {
        if (denied('update_permission')) return error('Forbidden', 403);

        try {
            $model = Permissions_Model::whereUrid($request_data['urid'])->first();
            if (!$model) {
                return error('Record Not Found', 404);
            }

            $validation = self::validate($request_data, $model);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $data = $validation['data'];

            $old_data = $model->toArray();

            $updated = $model->update($data);

            if (!$updated) {
                return error('Failed to update permission', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update Permission',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($model),
            ],'UPDATE-PERMISSION');

            return success('Success', $model);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

}

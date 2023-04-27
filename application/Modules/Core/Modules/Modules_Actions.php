<?php


namespace Application\Modules\Core\Modules;

use Application\Modules\Core\Status\Status_Model;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Modules_Actions

{
    private static $ACTOR = 'Modules';

    public static function index() {
        if (denied('view_modules')) return error('Forbidden', 403);
        try {
            $all_data = Modules_Model
                ::join('status', 'status.id','modules.status_id')
                ->select(['modules.*', 'status.name as status', 'status.color as status_color'])
                ->get();


            return success('Success', $all_data);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function viewModule($urid) {
        if (denied('view_module')) return error('Forbidden', 403);
        try {
            $item = Modules_Model
                ::join('status', 'status.id','modules.status_id')
                ->select(['modules.*', 'status.name as status', 'status.color as status_color'])
                ->where('modules.urid', $urid)
                ->first();

            $permissions = Modules_Model
                ::join('permissions', 'permissions.module_id', 'modules.id')
                ->select(['permissions.*'])
                ->where('modules.urid', $urid)
                ->get();

            $all_data['module'] = $item;
            $all_data['permissions'] = $permissions;

            return success('Success', $all_data);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function getModuleStatuses() {
        if (denied('view_modules')) return error('Forbidden', 403);

        try {
            $item = Status_Model::all();

            return success('Success', $item);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    private static function validate($data, $record = null) {
        $rules = [
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'module_type_id' => ['required', 'string'],
        ];

        if ($record == null) {
            $rules['name'][] = Rule::unique('modules');
            $rules['title'][] = Rule::unique('modules');
        } else {
            $rules['name'][] = Rule::unique('modules')->ignore($record->id);
            $rules['title'][] = Rule::unique('modules')->ignore($record->id);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()];
        }

        $data = $validator->validated();
        return ['status' => true, 'data' => $data];
    }

    public static function saveModule($request_data) {
        if (denied('save_module')) return error('Forbidden', 403);

        try {
            $validation = self::validate($request_data);
            if(!$validation['status']) return $validation;

            $data = $validation['data'];

            $data['status_id'] = 1;
            $item = Modules_Model::create($data);

            if (!$item) {
                return error('Failed to save module', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $item->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Module',
                'old_data' => null,
                'new_data' => json_encode($item),
            ],'SAVE-MODULE');

            return success('Success', $item);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function updateModule($request_data) {
        if (denied('update_module')) return error('Forbidden', 403);
        try {
            $record = Modules_Model::whereUrid($request_data['urid'])->first();
            if (!$record) {
                return error('Record not found', 404);
            }

            $validation = self::validate($request_data, $record);
            if(!$validation['status']) return $validation;

            $data = $validation['data'];

            $old_data = $record->toArray();

            $item = $record->update($data);

            if (!$item) {
                return error('Failed to update module', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update Module',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record),
            ],'UPDATE-MODULE');

            return success('Success', $record);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    private static function validateChangeModuleStatus($data) {
        $rules = [
            'urid' => ['required', 'string'],
            'status_id' => ['required', 'integer'],
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()];
        }

        $data = $validator->validated();
        return ['status' => true, 'data' => $data];
    }

    public static function changeModuleStatus($request_data) {
        if (denied('change_module_status')) return error('Forbidden', 403);

        try {
            $validation = self::validateChangeModuleStatus($request_data);
            if(!$validation['status']) return $validation;

            $model = Modules_Model::whereUrid($request_data['urid'])->first();
            if (!$model) {
                return error('Record not found', 404);
            }

            $data = $validation['data'];

            $old_data = $model->toArray();

            $item = $model->update([
                'status_id' => $data['status_id']
            ]);

            if (!$item) {
                return error('Failed to change module status', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Change Module Status',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($model),
            ],'CHANGE-MODULE_STATUS');

            return success('Success', $model);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

}

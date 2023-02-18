<?php


namespace Application\Modules\Core\Notifiers;

use Application\Modules\Core\Notifiers\Notifiers_Model;
use Application\Modules\Core\Status\Status;
use Application\Modules\Core\Status\Status_Model;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Notifiers_Actions

{
    private static $ACTOR = 'Notifiers';
    private static $TABLE = 'notifiers';

    public static function index() {
        if (denied('view_notifiers')) return sendError('Forbidden', 403);
        try {
            $all_data = Notifiers_Model
                ::join('status', 'status.id','modules.status_id')
                ->select(['notifiers.*', 'status.name as status', 'status.color as status_color'])
                ->get();

            return sendResponse('Success', $all_data);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function viewNotifier($urid) {
        if (denied('view_notifier')) return sendError('Forbidden', 403);
        try {
            $record = Notifiers_Model
                ::join('status', 'status.id','modules.status_id')
                ->select([self::$TABLE . '.*', 'status.name as status', 'status.color as status_color'])
                ->where(self::$TABLE .'.urid', $urid)
                ->first();

            return sendResponse('Success', $record);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function getNotifierStatuses() {
        if (denied('view_notifiers')) return sendError('Forbidden', 403);

        try {
            $item = Status_Model::all();

            return sendResponse('Success', $item);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    private static function validate($data, $record = null) {
        $rules = [
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'message' => ['required', 'string'],
            'type' => ['required', 'integer'],
            'status_id' => ['required', 'integer'],
        ];

        if ($record == null) {
            $rules['name'][] = Rule::unique(self::$TABLE);
            $rules['title'][] = Rule::unique(self::$TABLE);
        } else {
            $rules['name'][] = Rule::unique(self::$TABLE)->ignore($record->id);
            $rules['title'][] = Rule::unique(self::$TABLE)->ignore($record->id);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()];
        }

        $data = $validator->validated();
        return ['status' => true, 'data' => $data];
    }

    public static function saveNotifier($request_data) {
        if (denied('save_notifier')) return sendError('Forbidden', 403);

        try {
            $validation = self::validate($request_data);
            if(!$validation['status']) return $validation;

            $data = $validation['data'];

            $data['status_id'] = Status::ACTIVE;
            $item = Notifiers_Model::create($data);

            if (!$item) {
                return sendError('Failed to save notifier', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $item->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Notifier',
                'old_data' => null,
                'new_data' => json_encode($item),
            ],'SAVE-NOTIFIER');

            return sendResponse('Success', $item);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function updateNotifier($request_data, $urid) {
        if (denied('update_notifier')) return sendError('Forbidden', 403);
        try {
            $record = Notifiers_Model::whereUrid($urid)->first();
            if (!$record) {
                return sendError('Record not found', 404);
            }

            $validation = self::validate($request_data, $record);
            if(!$validation['status']) return $validation;

            $data = $validation['data'];

            $old_data = $record->toArray();

            $item = $record->update($data);

            if (!$item) {
                return sendError('Failed to update notifier', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update Notifier',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record),
            ],'UPDATE-NOTIFIER');

            return sendResponse('Success', $record);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

    public static function changeNotifierStatus($request_data, $urid) {
        if (denied('change_module_status')) return sendError('Forbidden', 403);

        try {
            $model = Notifiers_Model::whereUrid($urid)->first();
            if (!$model) {
                return sendError('Record not found', 404);
            }

            $validation = validateData($request_data, [
                'status_id' => ['required','integer']
            ]);
            if (!$validation['status']) return sendValidationError($validation['error']);

            $model = Notifiers_Model::whereUrid($urid)->first();
            if (!$model) {
                return sendError('Record not found', 404);
            }

            $data = $validation['data'];

            $old_data = $model->toArray();

            $item = $model->update([
                'status_id' => $data['status_id']
            ]);

            if (!$item) {
                return sendError('Failed to change module status', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $model->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Change Notifier Status',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($model),
            ],'CHANGE-MODULE_STATUS');

            return sendResponse('Success', $model);
        } catch (Exception $exception) {
            return sendError($exception->getMessage(), 500);
        }
    }

}

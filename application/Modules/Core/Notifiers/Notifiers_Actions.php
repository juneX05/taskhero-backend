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
        if (denied('view_notifiers')) return error('Forbidden', 403);
        try {
            $all_data = Notifiers_Model
                ::join('status', 'status.id',self::$TABLE . '.status_id')
                ->select([self::$TABLE . '.*', 'status.name as status', 'status.color as status_color'])
                ->get();

            return success('Success', $all_data);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function viewNotifier($urid) {
        if (denied('view_notifier')) return error('Forbidden', 403);
        try {
            $record = Notifiers_Model
                ::join('status', 'status.id',self::$TABLE . '.status_id')
                ->select([self::$TABLE . '.*', 'status.name as status', 'status.color as status_color'])
                ->where(self::$TABLE .'.urid', $urid)
                ->first();

            return success('Success', $record);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function getNotifierStatuses() {
        if (denied('view_notifiers')) return error('Forbidden', 403);

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
            'message' => ['required', 'string'],
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
        if (denied('save_notifier')) return error('Forbidden', 403);

        try {
            $validation = self::validate($request_data);
            if(!$validation['status']) return $validation;

            $data = $validation['data'];

            $data['status_id'] = Status::ACTIVE;
            $item = Notifiers_Model::create($data);

            if (!$item) {
                return error('Failed to save notifier', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $item->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Save Notifier',
                'old_data' => null,
                'new_data' => json_encode($item),
            ],'SAVE-NOTIFIER');

            return success('Success', $item);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function updateNotifier($request_data, $urid) {
        if (denied('update_notifier')) return error('Forbidden', 403);
        try {
            $record = Notifiers_Model::whereUrid($urid)->first();
            if (!$record) {
                return error('Record not found', 404);
            }

            $validation = self::validate($request_data, $record);
            if(!$validation['status']) return $validation;

            $data = $validation['data'];

            $old_data = $record->toArray();

            $item = $record->update($data);

            if (!$item) {
                return error('Failed to update notifier', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Update Notifier',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record),
            ],'UPDATE-NOTIFIER');

            return success('Success', $record);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function deactivateNotifier($urid) {
        if (denied('deactivate_notifier')) return error('Forbidden', 403);
        try {
            $record = Notifiers_Model::whereUrid($urid)->first();
            if (!$record) {
                return error('Record not found', 404);
            }

            $data['status_id'] = Status::INACTIVE;

            $old_data = $record->toArray();

            $item = $record->update($data);

            if (!$item) {
                return error('Failed to deactivate notifier', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Deactivate Notifier',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record),
            ],'DEACTIVATE-NOTIFIER');

            return success('Success', $record);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

    public static function activateNotifier($urid) {
        if (denied('activate_notifier')) return error('Forbidden', 403);
        try {
            $record = Notifiers_Model::whereUrid($urid)->first();
            if (!$record) {
                return error('Record not found', 404);
            }

            $data['status_id'] = Status::ACTIVE;

            $old_data = $record->toArray();

            $item = $record->update($data);

            if (!$item) {
                return error('Failed to activate notifier', 500);
            }

            logInfo(__FUNCTION__,[
                'actor_id' => $record->urid,
                'actor' => self::$ACTOR,
                'action_description' => 'Activate Notifier',
                'old_data' => json_encode($old_data),
                'new_data' => json_encode($record),
            ],'ACTIVATE-NOTIFIER');

            return success('Success', $record);
        } catch (Exception $exception) {
            return error($exception->getMessage(), 500);
        }
    }

}

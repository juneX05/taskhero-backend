<?php

namespace Application\Modules\Core\Logs;

class Logs
{
    const CREATED = 'created';
    const UPDATED = 'updated';
    const DELETED = 'deleted';
    const INFO = 'info';

    public static $ACTOR;
    public static $ACTOR_ID;
    public static $REQUEST_ID = null;
    public static $PROCESS = null;

    public static function pullHistory($module, $record_id) {
        return LogInfo_Model
            ::with('request')
            ->where(['actor' => $module, 'actor_id' => $record_id])
            ->orderBy('id', 'DESC')->get()->toArray();
//        dd($data);
    }

    private static function getDiff($old_data, $new_data) {
        $data = [];
        foreach ($new_data as $key => $value) {
            $old_value = $old_data[$key] ?? null;
            if ($value != $old_value) {
                $data['old'] = $old_value;
                $data['new'] = $value;
            }
        }
        return $data;
    }

    public static function saveLog($actor, $action, $action_type, $new_record, $old_record = [], $description = '') {

        LogInfo_Model::create([
            'request_id' => self::$REQUEST_ID,
            'actor' => $actor,
            'actor_id' => $new_record['urid'],
            'action_type' => $action_type,
            'action_name' => $action,
            'action_description' => $description,
            'old_data' => $old_record,
            'new_data' => $new_record,
        ]);

        \Log::info('Log saved');
    }

    public static function saveLogInfo($action_type, $action_name, $action_description = '' ) {

        LogInfo_Model::create([
            'request_id' => self::$REQUEST_ID,
            'process' => self::$PROCESS,
            'actor' => self::$ACTOR,
            'actor_id' => self::$ACTOR_ID,
            'action_type' => $action_type,
            'action_name' => $action_name,
            'action_description' => $action_description,
            'old_data' => [],
            'new_data' => [],
        ]);
    }
}

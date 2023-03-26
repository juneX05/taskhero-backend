<?php

namespace Application\Modules\Core\Logs;
use Illuminate\Support\Facades\Auth;

class Logs_Actions {

    public static function initiateLog() {
        $data = [];
        $data['request_url'] = request()->url();
        $data['request_method'] = request()->getMethod();
        $data['request_data'] = json_encode(request()->all());
        $data['request_content_type'] = request()->getContentType();
        $data['request_client_ips'] = json_encode(request()->getClientIps());
        $data['request_id'] = Logs::$REQUEST_ID;
        if (request()->user()) {
            $data['user'] = Auth::user()->name;
            $data['user_id'] = Auth::user()->id;
        } else {
            $data['user'] = 'Guest';
            $data['user_id'] = 0;
        }

        Logs_Model::create($data);

    }

    public static function saveQuickLog($data) {
        $data['actor'] = Logs::$ACTOR ?? 'SYSTEM';

        self::saveLog($data);
    }

    public static function saveLog($data) {
        Logs::$REQUEST_ID = Logs::$REQUEST_ID ??  hrtime(true);
        $data['request_id'] = Logs::$REQUEST_ID;

        LogInfo_Model::create([
            'request_id' => $data['request_id'],
            'actor' => $data['actor'],
            'actor_id' => $data['actor_id'],
            'action_type' => $data['action_type'],
            'action_name' => $data['action_name'],
            'action_description' => $data['action_description'],
            'old_data' => $data['old_data'],
            'new_data' => $data['new_data'],
        ]);
    }

}

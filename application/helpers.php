<?php

use Application\ApplicationBootstrapper;
use Application\Modules\Core\Logs\Jobs\LogActivity;
use Application\Modules\Core\Logs\Logs;
use Application\Modules\Core\Logs\Logs_Actions;
use Application\Modules\Core\Modules\Modules_Actions;
use Application\Modules\Core\Modules\Modules_Model;
use Application\Modules\Core\Permissions\Permissions_Actions;
use Application\Modules\Core\Permissions\Permissions_Model;
use Application\Modules\Core\Roles\_Modules\RolePermissions\RolePermissions_Model;
use Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions_Model;
use Application\Modules\Core\Users\_Modules\UserRoles\UserRoles_Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

function logInfo($tag, $data, $action_type = 'LOG')
{
    $data['action_type'] = $action_type;
    $data['action_name'] = $tag;

    if ($action_type == 'LOG') {
        $data['new_data'] = ($data);
        $data['action_description'] = null;
        $data['old_data'] = null;
        $data['actor_id'] = null;
        Logs_Actions::saveQuickLog($data);
    } else {
        Logs_Actions::saveLog($data);
    }
}

/**
 * success response method.
 *
 * @return \Illuminate\Http\JsonResponse
 */
function sendResponse($result)
{
    if ($result['status']) {
        return response()->json($result);
    }

    return sendErrorResponse($result['error']);

}

function sendSuccessResponse($message, $result = []) {
    $response = [
        'status' => true,
        'message' => $message,
    ];

    logInfo('RESPONSE', $response);

    $response['data'] = $result;

    return response()->json($response);
}

/**
 * @param $errorBag array|string
 * @return \Illuminate\Http\JsonResponse
 */
function sendErrorResponse($errorBag)
{
    $request_id = Logs::$REQUEST_ID;

    $code = 500;
    if (gettype($errorBag) == 'string') {
        $message = $errorBag;
        $type = 'Error';
        $data = [];
    } else {
        $type = $errorBag['type'] ?? 'Error';
        $message = $errorBag['error'] ?? '';
        $data = $errorBag['data'] ?? [];
        $code = $errorBag['code'] ?? $code;
    }

    switch ($type) {
        case 'Forbidden' :
            $code = 403;
            $message = 'You are not allowed to access this resource';
            break;

        case 'Unauthorized':
            $code = 401;
            $message = 'You are not authorized';
            break;

        case 'ValidationError':
            $code = 422;
            $message = 'Validation Failed';
            break;

        case 'ExceptionError':
            $code=500;
            if (env('APP_ENV') != 'local')
                $message = 'An Error Occurred. Please contact administrator.';
            break;
    }

    $message .= " | REQUEST-ID({$request_id})";

    $response = [
        'status' => false,
        'message' => $message,
        'data' => $data
    ];

    logInfo('RESPONSE', $response);

    return response()->json($response, $code);
}

function sendValidationError($errors) {
    $error = [
        'type' => 'ValidationError',
        'data' => $errors
    ];

   return sendErrorResponse($error);
}

function sendExceptionErrorResponse(TypeError|\Throwable $exception) {
    $error = [
        'type' => 'ExceptionError',
        'error' => $exception->getMessage(),
        'data' => $exception->getTrace()
    ];

   return sendErrorResponse($error);
}

function seedPermissions($permissions) {
    foreach ($permissions as $permission) {
        if (!Permissions_Model::whereName($permission['name'])->first()) {
            Permissions_Actions::_createPermission($permission);
        }
    }
}

function seedModule($module) {
    if (!Modules_Model::whereName($module['name'])->first()) {
        Modules_Model::create($module);
    }
}

function application_path() {
    return base_path() . DIRECTORY_SEPARATOR . 'application';
}

function modules_path() {
    return application_path() . DIRECTORY_SEPARATOR . 'Modules';
}

function core_modules_path() {
    return modules_path() . DIRECTORY_SEPARATOR . 'Core';
}

function system_modules_path() {
    return modules_path() . DIRECTORY_SEPARATOR . 'System';
}

function getSeederData($module) {
    $core_seeder = core_modules_path()."/$module/Seeder/data.json";
    $system_seeder = system_modules_path()."/$module/Seeder/data.json";

    if (file_exists($core_seeder)) {
        $seeder_data = json_decode(file_get_contents($core_seeder), true);
    } elseif (file_exists($system_seeder)) {
        $seeder_data = json_decode(file_get_contents($system_seeder), true);
    }

    if (!isset($seeder_data['permissions'])) {
        $seeder_data['permissions'] = [];
    }

    if (!isset($seeder_data['data'])) {
        $seeder_data['data'] = [];
    }

    if (!isset($seeder_data['module'])) {
        $seeder_data['module'] = [];
    }

    return $seeder_data;
}

function getUserPermissions($user_id) {
    $permission_key = 'permissions.name';

    $user_roles_data = UserRoles_Model::whereUserId($user_id)
        ->whereStatusId(1)
        ->pluck('role_id')->toArray();

    $roles_permissions = RolePermissions_Model::whereIn('role_id', $user_roles_data)
        ->join('permissions', 'role_permissions.permission_id','=', 'permissions.id')
        ->where('role_permissions.status_id',1)
        ->distinct()
        ->pluck('role_permissions.status_id',$permission_key)
        ->toArray();

    $users_permissions = UserPermissions_Model::where('user_id', $user_id)
        ->join('permissions', 'user_permissions.permission_id','=', 'permissions.id')
        ->distinct()
        ->pluck('status_id', $permission_key)
        ->toArray();

    $user_permissions = array_merge($roles_permissions, $users_permissions);

    $permissions = [];
    foreach ($user_permissions as $permission => $status) {
        if ($status != 2) $permissions[] = $permission;
    }
    return $permissions;
}

function uploads_path() {
    return base_path() . "/application/Uploads";
}

function denied($permission) {
    return Gate::denies($permission);
}

function validateData($request_data, $rules, $messages = []) {
    $validator = Validator::make($request_data, $rules, $messages);

    if ($validator->fails()) {
        return ['status' => false, 'data' => $validator->errors(), 'type' => 'ValidationError'];
    }

    $data = $validator->validated();
    return ['status' => true, 'data' => $data];
}

function dde($data) {
    echo json_encode($data, JSON_PRETTY_PRINT); exit;
}

function verifyRequest() {
    if (!request()->bearerToken()) {
//        dd(Auth::user());

        return Auth::check();
    }

    $token = PersonalAccessToken::findToken(request()->bearerToken());

    if ($token) return true;

    return false;
}

function error($error, $code = null) {

    if ($code == null) {
        return [
            'status' => false,
            'error' => $error
        ];
    }

    return [
        'status' => false,
        'error' => ['error' => $error, 'code' => $code]
    ];
}

function success($message = 'success', $data = []) {
    return [
        'status' => true,
        'message' => $message,
        'data' => $data,
    ];
}

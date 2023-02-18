<?php

use Application\ApplicationBootstrapper;
use Application\Modules\Core\Logs\Logs_Actions;
use Application\Modules\Core\Permissions\Permissions_Actions;
use Application\Modules\Core\Permissions\Permissions_Model;
use Application\Modules\Core\Roles\_Modules\RolePermissions\RolePermissions_Model;
use Application\Modules\Core\Users\_Modules\UserPermissions\UserPermissions_Model;
use Application\Modules\Core\Users\_Modules\UserRoles\UserRoles_Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

function logInfo($tag, $data, $action_type = 'LOG')
{
    $data['action_type'] = $action_type;
    $data['action_name'] = $tag;

    if ($action_type == 'LOG') {
        $data['new_data'] = json_encode($data);
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
function sendResponse($message, $result = [], $code = 200)
{
    $response = [
        'status' => true,
        'data' => $result,
        'message' => $message,
    ];

    logInfo('RESPONSE', $response);

    return response()->json($response, $code);
}

/**
 * return error response.
 *
 * @return \Illuminate\Http\JsonResponse
 */
function sendError($error, $code)
{
    $response = ['status' => false, 'message' => $error];

    if (gettype($error) == "array") {

        $response['message'] = 'Validation Failed';
        $response['data'] = $error['data'];
        $code = 422;

    } else {

        if ($error == 'Forbidden') {
            $code = 403;
            $response['message'] = 'You are not allowed to access this resource';
        }

        if ($error == 'Unauthorized') {
            $code = 401;
            $response['message'] = 'You are not authorized';
        }

    }

    $request_id = Logs_Actions::$REQUEST_ID;
    $response['message'] .= " | REQUEST-ID({$request_id})";

    logInfo('RESPONSE', $response);

    return response()->json($response, $code);
}

function sendValidationError($errors) {
    $response = [
        'status' => false,
        'message' => 'Validation Failed',
        'data' => $errors
    ];

    $request_id = Logs_Actions::$REQUEST_ID;
    $response['message'] .= " | REQUEST-ID({$request_id})";

    logInfo('RESPONSE', $response);

    return response()->json($response, 422);
}

function seedPermissions($permissions) {
    foreach ($permissions as $permission) {
        if (!Permissions_Model::whereName($permission['name'])->first()) {
            Permissions_Actions::_createPermission($permission);
        }
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

    return $seeder_data;
}

function getUserPermissions($user_id) {
    $permission_key = 'permissions.name';

    $user_roles_data = UserRoles_Model::whereUserId($user_id)->pluck('role_id')->toArray();

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

    $user_permissions = array_merge_recursive($roles_permissions, $users_permissions);

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

function validateData($request_data, $rules) {
    $validator = Validator::make($request_data, $rules);

    if ($validator->fails()) {
        return ['status' => false, 'error' => $validator->errors()];
    }

    $data = $validator->validated();
    return ['status' => true, 'data' => $data];
}

function dde($data) {
    echo json_encode($data, JSON_PRETTY_PRINT); exit;
}

function verifyRequest() {
    $token = PersonalAccessToken::findToken(request()->bearerToken());

    if ($token) return true;

    return false;
}


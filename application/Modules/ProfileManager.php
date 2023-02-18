<?php

namespace Application\Modules;

use Application\Modules\Core\Users\Users_Model;
use Application\Modules\System\Applicants\Applicants_Model;
use Application\Modules\System\Districts\Districts_Model;
use Application\Modules\System\Genders\Genders_Model;
use Application\Modules\System\Institutions\Institutions_Model;
use Application\Modules\System\Members\Members_Model;
use Application\Modules\System\Nationalities\Nationalities_Model;
use Application\Modules\System\Titles\Titles_Model;
use Illuminate\Validation\Rule;

class ProfileManager
{
    public static function fetch(Users_Model $user) {
        switch ($user->user_type_id){
//            case 5:
//                return self::membersProfile($user);
            default:
                return self::defaultProfile($user);
        }
    }

    public static function update(Users_Model $user, $request_data) {
        switch ($user->user_type_id){
//            case 5:
//                return self::membersProfile($user);
            default:
                return self::defaultProfileUpdate($user, $request_data);
        }
    }

    private static function defaultProfile($user) {
        $data = Users_Model::where('users.id', $user->id)
            ->join('user_status','user_status.id','users.user_status_id')
            ->first([
                'users.*',
                'user_status.name as status',
                'user_status.color as status_color',
            ]);
        return [
            'status' => true,
            'data' => [
                'type' => 'user',
                'user' => $data,
                'profile' => null,
            ]
        ];
    }

    private static function defaultProfileUpdate(Users_Model $user, $request_data) {
        $validation = validateData($request_data, [
            'name' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        if (!$validation['status']) return ['status' => false, 'message' => 'validation_error', 'error' => $validation['error']];

        $data = $validation['data'];

        $update = $user->update($data);
        if (!$update) return ['status' => false, 'message' => 'Failed to update profile'];

        return ['status' => true, 'message' => 'Profile Update Successful'];
    }

}

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

class ProfileManager
{
    public static function fetch(Users_Model $user) {
        switch ($user->user_type_id){
            case 5:
                return self::membersProfile($user);
            default:
                return self::defaultProfile($user);
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

    public static function membersProfile(Users_Model $user) {
        //get the member.
        $member = Members_Model::whereUserId($user->id)->first();

        if (!$member) return ['status' => false, 'error' => 'Member not found'];

        return self::getMemberProfile($member, $user);
    }

    public static function getMemberProfile($member, $user) {
        switch ($member->membership_type_id) {
            case 1:
                return self::corporateMemberProfile($user, $member);
            default:
                return self::applicantMemberProfile($user, $member);
//                return ['status' => false, 'error' => 'Membership Type not found'];
        }
    }

    private static function corporateMemberProfile(Users_Model $user, Members_Model $member) {
        $profile = Institutions_Model::whereMemberId($member->id)->first();

        return [
            'status' => true,
            'data' => [
                'type' => 'institution',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_id' => $user->urid,
                    'member_id' => $member->urid,
                    'created_at' => $member->created_at,
                ],
                'profile' => $profile,
            ]
        ];
    }

    private static function applicantMemberProfile(Users_Model $user, Members_Model $member) {
        $profile = Applicants_Model
            ::whereMemberId($member->id)
            ->join('districts','districts.id','applicants.district_id')
            ->join('titles','titles.id','applicants.title_id')
            ->join('nationalities','nationalities.id','applicants.nationality_id')
            ->join('genders','genders.id','applicants.gender_id')
            ->first([
                'applicants.*',
                'districts.title as district',
                'titles.title as title',
                'nationalities.title as nationality',
                'genders.title as gender',
            ]);

        return [
            'status' => true,
            'data' => [
                'type' => 'applicant',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_id' => $user->urid,
                    'member_id' => $member->urid,
                    'created_at' => $member->created_at,
                ],
                'profile' => $profile,
                'splash' => [
                    'districts' => Districts_Model::all(),
                    'nationalities' => Nationalities_Model::all(),
                    'genders' => Genders_Model::all(),
                    'titles' => Titles_Model::all(),
                ]
            ]
        ];
    }


}

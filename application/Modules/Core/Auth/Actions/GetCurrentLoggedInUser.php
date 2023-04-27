<?php

namespace Application\Modules\Core\Auth\Actions;

use Application\Modules\Core\Menus\Menus_Actions;
use Application\Modules\ProfileManager;

class GetCurrentLoggedInUser
{
    public static function boot() {
//        if(!verifyRequest()) return error('Unauthenticated', 401);

        $profile = ProfileManager::fetch(request()->user());
        if (!$profile['status']) {
            return error('User has no profile');
        }

        $user = $profile['data']['user'];

        $sidebar_menus = Menus_Actions::sidebarMenus();

        $response = [
            'permissions' => getUserPermissions(request()->user()->id),
            'user' => $user,
            'menus' => $sidebar_menus
        ];
        return success('User Data',$response );
    }
}

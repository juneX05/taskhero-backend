<?php


namespace Application;

use Application\Modules\Core\Permissions\Permissions_Model;
use Application\Modules\Core\Users\_Modules\UserStatus\UserStatus;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ApplicationGatesMiddleware
{
    public function handle($request, Closure $next)
    {
        $all_permissions = Permissions_Model::all()->pluck('name')->toArray();
        $user = Auth::user();
        if ($user) {
            $user_permissions = getUserPermissions(Auth::user() ? Auth::user()->id : 0);

            foreach ($all_permissions as $permission) {
                Gate::define($permission, function ($user) use ($permission, $user_permissions) {
                    return in_array($permission, $user_permissions);
                });
            }

            if ($user->user_status_id != UserStatus::ACTIVE) {
                return sendError('Your account is not active.', 419);
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $guard = null)
    {

        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        if ($this->can($request, $permission)) {
            return $next($request);
        }

        abort(403);
    }

    /**
     * Checks a Permission
     *
     * @param  String permission Slug of a permission (i.e: manage_user)
     * @return Boolean true if has permission, otherwise false
     */
    public function can($request, $permission = null)
    {
        return !is_null($permission) && $this->checkPermission($request, $permission);
    }

    /**
     * Check if the permission matches with any permission user has
     *
     * @param  String permission slug of a permission
     * @return Boolean true if permission exists, otherwise false
     */
    protected function checkPermission($request ,$perm)
    {
        $permissions = $this->getAllPernissionsFormAllRoles($request);
        $permissionArray = explode('|', $perm);

        return count(array_intersect($permissions, $permissionArray));
    }

    /**
     * Get all permission slugs from all permissions of all roles
     *
     * @return Array of permission slugs
     */
    protected function getAllPernissionsFormAllRoles($request)
    {
        $permissions = $request->user()->roles->load('permissions')->toArray();

        return array_map('strtolower',
            array_unique(
                array_flatten(
                    array_map(
                        function ($permission) {
                            return array_pluck($permission['permissions'], 'slug');
                        }, $permissions
                    )
                )
            )
        );
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $guard = null)
    {

        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/');
            }
        }

        if ($this->can($request, $role)) {
            return $next($request);
        }

        abort(403);
    }

    /**
     * Checks a Permission
     *
     * @param  String role Slug of a role (i.e: manage_user)
     * @return Boolean true if has role, otherwise false
     */
    public function can($request, $role = null)
    {
        return !is_null($role) && $this->checkRole($request, $role);
    }

    /**
     * Check if the role matches with any role user has
     *
     * @param  String role slug of a role
     * @return Boolean true if role exists, otherwise false
     */
    protected function checkRole($request ,$role)
    {
        $roles = $this->getAllRoles($request);
        $rolesArray = explode('|', $role);

        return count(array_intersect($roles, $rolesArray));
    }

    /**
     * Get all role slugs from all roles of all roles
     *
     * @return Array of role slugs
     */
    protected function getAllRoles($request)
    {
        $roles = $request->user()->load('roles')->toArray();

        return array_map('strtolower',
            array_unique(
                array_flatten(
                    array_pluck($roles['roles'], 'slug')
                )
            )
        );
    }
}

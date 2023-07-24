<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Closure;
use Illuminate\Routing\Route;

class CheckForAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $protected_modules = [];
        foreach (Group::SYSTEM_MODULES['navigation'] as $module) {
            foreach ($module as $module_value) {
                if (!empty($module_value)) {
                    foreach ($module_value as $value) {
                        $protected_modules[] = $value;
                    }
                }
            }
        }

        $exclude_bypass_array = ['home', 'dashboard', 'profile'];

        $accesses_urls = [];
        if (auth()->check()) {
            $user_group          = auth()->user()->group;
            $user_group_accesses = isset($user_group) && !empty($user_group) && !empty($user_group->accesses) ? $user_group->accesses : '';
            if (isset($user_group_accesses) && !empty($user_group_accesses)) {
                foreach ($user_group_accesses as $access) {
                    $accesses_urls[] = $access->module;
                }
            }
        }

        if (isset(auth()->user()->is_root_user)
            && auth()->user()->is_root_user == 0
            && in_array($request->route()->getName(), $protected_modules)
            && !in_array($request->route()->getName(), $accesses_urls)
            && !in_array($request->route()->getName(), $exclude_bypass_array)) {
            return redirect()->route('401');
        }

        return $next($request);
    }
}

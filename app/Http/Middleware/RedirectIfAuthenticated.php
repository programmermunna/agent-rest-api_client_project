<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated.
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $redirectionRoute = redirect(RouteServiceProvider::HOME);
            if (App::isDownForMaintenance()) {
                $request->session()->flash('errorNotif', 'Application is Maintenance Mode!');
                $redirectionRoute = redirect(route('admin.setting.maintenance.index'));
            }

            return $redirectionRoute;
        }

        return $next($request);
    }
}

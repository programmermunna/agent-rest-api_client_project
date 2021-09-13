<?php

namespace App\Http\Middleware;

use Closure;

class LogViewerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->key == 'whoamiandiamwho') {
            return $next($request);
        }

        return redirect('/');
    }
}

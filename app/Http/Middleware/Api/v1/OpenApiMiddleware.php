<?php

namespace App\Http\Middleware\Api\v1;

use App\Traits\ApiResponser;
use Closure;

class OpenApiMiddleware
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('secret') == 'secret') {
             return $next($request);
        }

        return $this->errorResponse('Access denied', 403);
    }
}
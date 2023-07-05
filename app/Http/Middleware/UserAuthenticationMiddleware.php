<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;
use JWTAuth;

class UserAuthenticationMiddleware
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->header('Authorization');
            $rememberToken = 'Bearer ' . auth('api')->user()->remember_token;

            if ($token == $rememberToken) {
                return $next($request);
            }

            JWTAuth::parseToken()->invalidate($token);

            return $this->errorResponse('Authorization Token not found', 400);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500, $th->getMessage());
        }
    }
}

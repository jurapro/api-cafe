<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ApiUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()->hasRole(explode('|', $role))) {
            throw new ApiException(403, 'Forbidden for you');
        }
        return $next($request);
    }
}

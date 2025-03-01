<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdmin
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

        $user = user();
        abort_if(!is_null($user->restaurant_id), 403);

        return $next($request);
    }

}

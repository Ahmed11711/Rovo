<?php

namespace App\Http\Middleware;

use Closure;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class DisableFrontend
{
    use AppBoot;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->showInstall();

        try {
            $global = global_setting();

            if ($global->disable_landing_site && !request()->ajax()) {
                return redirect(route('login'));
            }
        } catch (\Exception $e) {
            // return redirect(route('login'));
        }

        return $next($request);
    }
}

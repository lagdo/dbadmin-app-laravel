<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Lagdo\DbAdmin\App\DbAdminPackage;
use Symfony\Component\HttpFoundation\Response;
use Closure;

use function config_path;
use function route;

class DbAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Register the DbAdmin package.
        DbAdminPackage::register(config_path('/dbadmin'), route('dbadmin.jaxon'));

        return $next($request);
    }
}

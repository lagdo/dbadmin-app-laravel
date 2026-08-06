<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Lagdo\DbAdmin\App\DbAuditPackage;
use Symfony\Component\HttpFoundation\Response;
use Closure;

use function config_path;
use function route;

class DbAuditMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Register the DbAudit package.
        DbAuditPackage::register(config_path('/dbadmin'), route('dbaudit.jaxon'));

        return $next($request);
    }
}

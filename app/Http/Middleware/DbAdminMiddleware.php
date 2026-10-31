<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Lagdo\DbAdmin\App\DbAdminPackage;
use Lagdo\DbAdmin\App\Ui\AdminUiBuilder;
use Symfony\Component\HttpFoundation\Response;
use Closure;

use function config_path;
use function Jaxon\jaxon;
use function resource_path;
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

        // Register the view namespace
        $jaxon = jaxon();
        $template = $jaxon->getAppOption('template', '');
        View::addNamespace('dbadmin', resource_path("views/$template"));
        View::share([
            'di' => $jaxon->di(),
            'ui' => AdminUiBuilder::class,
            'package' => DbAdminPackage::class,
        ]);

        return $next($request);
    }
}

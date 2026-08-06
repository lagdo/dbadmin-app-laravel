<?php

use App\Http\Middleware\DbAdminMiddleware;
use App\Http\Middleware\DbAuditMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Jaxon\Exception\Exception as JaxonException;
use Jaxon\Laravel\App\Jaxon;
use Lagdo\DbAdmin\App\Ajax\Exception\AppException;
use Lagdo\DbAdmin\App\Ajax\Exception\ValidationException;
use Lagdo\DbAdmin\Driver\Exception\DriverException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->group('jaxon.dbadmin.config', [
            DbAdminMiddleware::class,
            'jaxon.config',
        ]);
        $middleware->group('jaxon.dbaudit.config', [
            DbAuditMiddleware::class,
            'jaxon.config',
            'can:audit',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // When the session expires, redirect any Jaxon request to the login page.
        $exceptions->respond(function (Response $response) {
            $jaxon = app()->make(Jaxon::class);
            if ($response->getStatusCode() !== 419 || !$jaxon->canProcessRequest()) {
                return $response;
            }

            // Handle token expiration errors on Jaxon requests.
            $ajaxResponse = $jaxon->ajaxResponse();
            $ajaxResponse->redirect(route('login'));
            return $jaxon->httpResponse();
        });

        // Show the error messages in a dialog
        $exceptions->render(fn(AppException $e) => showMessage($e->getMessage(), false));
        $exceptions->render(fn(ValidationException $e) => showMessage($e->getMessage(), false));
        $exceptions->render(fn(DriverException $e) => showMessage($e->getMessage(), true));
        $exceptions->render(fn(JaxonException $e) => showMessage($e->getMessage(), true));
        $exceptions->render(function(Exception $e) {
            $errorMessage = 'Unable to process the request. Unexpected error.';
            // Also show the exception message in debug env.
            if (env('APP_DEBUG', false)) {
                $errorMessage .= ' ' . $e->getMessage();
            }
            $jaxon = app()->make(Jaxon::class);
            if ($jaxon->canProcessRequest()) {
                return showMessage($errorMessage, true);
            }
        });
    })->create();

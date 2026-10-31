<?php

use Illuminate\Support\Facades\Route;
use Lagdo\DbAdmin\Support\Facade\Export;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', fn() => view('dbadmin::dbadmin'))
    ->middleware(['auth', 'jaxon.dbadmin.config']);

Route::post('/jaxon', fn() => response()->json([]))
    ->middleware(['web', 'jaxon.dbadmin.config', 'jaxon.ajax'])
    ->name('dbadmin.jaxon');

Route::get('/export/{filename}', function(string $filename) {
    $options = Export::options($filename);
    $exports = Export::export($options);
    return $exports === null ?
        response("Unable to export file $filename.")
            ->header('Content-Type', 'text/plain')
            ->setStatusCode(403) :
        response()->streamDownload(function() use($exports) {
            foreach ($exports as $export) {
                echo $export;
                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();
            }
        }, $options->filename, [
            'Content-Type' => $options->contentType(),
            'Content-Disposition' => $options->contentDisposition(),
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
})->middleware(['auth', 'jaxon.dbadmin.config'])
    ->name('dbadmin.file');

Route::get('/audit', fn() => view('dbadmin::dbaudit'))
    ->middleware(['auth', 'jaxon.dbaudit.config'])
    ->name('dbaudit');

Route::post('/audit/jaxon', fn() => response()->json([]))
    ->middleware(['web', 'jaxon.dbaudit.config', 'jaxon.ajax'])
    ->name('dbaudit.jaxon');

// Logout
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout.get')->middleware('auth');

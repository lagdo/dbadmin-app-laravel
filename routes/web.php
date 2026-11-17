<?php

use Illuminate\Support\Facades\Route;
use Lagdo\DbAdmin\Support\Facade\Export;
use Lagdo\DbAdmin\Support\Facade\Import;
use Lagdo\DbAdmin\Support\Service\Export\ExportService;
use Lagdo\DbAdmin\Support\Service\Import\ImportService;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', fn() => view('dbadmin::dbadmin'))
    ->middleware(['auth', 'jaxon.dbadmin.config']);

Route::post('/jaxon', fn() => response()->json([]))
    ->middleware(['web', 'jaxon.dbadmin.config', 'jaxon.ajax'])
    ->name('dbadmin.jaxon');

Route::get('/export/{filename}', function(string $filename) {
    /** @var ExportService */
    $service = Export::instance();
    $options = $service->options($filename, ['timeLimit' => 0]);
    $exports = $options === null ? null : $service->export($options);
    if ($exports === null) {
        return response("Unable to export file $filename.")
            ->header('Content-Type', 'text/plain')
            ->setStatusCode(403);
    }

    // Unlock the session before starting the streaming.
    session()->save();

    return response()->streamDownload(function() use($exports) {
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
    ->name('dbadmin.export');

Route::get('/import/{filename}', function(string $filename) {
    /** @var ImportService */
    $service = Import::instance();
    $options = $service->options($filename, ['timeLimit' => 0]);
    $imports = $options === null ? null : $service->import($options);
    if ($imports === null) {
        return response("Unable to import file $filename.")
            ->header('Content-Type', 'text/plain')
            ->setStatusCode(403);
    }

    // Unlock the session before starting the streaming.
    session()->save();

    return response()->streamDownload(function() use($imports) {
        foreach ($imports as $import) {
            echo $import;
            if (ob_get_level() > 0) {
                ob_flush();
            }
            flush();
        }
    }, $options->file['log'], [
        'Content-Type' => $options->contentType(),
        'Content-Disposition' => $options->contentDisposition(),
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
        'X-Accel-Buffering' => 'no',
    ]);
})->middleware(['auth', 'jaxon.dbadmin.config'])
    ->name('dbadmin.import');

Route::get('/audit', fn() => view('dbadmin::dbaudit'))
    ->middleware(['auth', 'jaxon.dbaudit.config'])
    ->name('dbaudit');

Route::post('/audit/jaxon', fn() => response()->json([]))
    ->middleware(['web', 'jaxon.dbaudit.config', 'jaxon.ajax'])
    ->name('dbaudit.jaxon');

// Logout
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout.get')->middleware('auth');

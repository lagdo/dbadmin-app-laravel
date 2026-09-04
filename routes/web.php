<?php

use Illuminate\Support\Facades\Route;
use Lagdo\DbAdmin\App\DbAdminPackage;
use Lagdo\DbAdmin\App\DbAuditPackage;
use Lagdo\DbAdmin\Support\Facade\FileSystem;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', fn() => view('dbadmin', ['package' => DbAdminPackage::class]))
    ->middleware(['auth', 'jaxon.dbadmin.config']);

Route::post('/jaxon', fn() => response()->json([]))
    ->middleware(['web', 'jaxon.dbadmin.config', 'jaxon.ajax'])
    ->name('dbadmin.jaxon');

Route::get('/export/{filename}', function(string $filename) {
    $fs = FileSystem::instance();
    return response($fs?->read($filename) ?? 'No export reader set.')
        ->header('Content-Type', 'text/plain')
        ->setStatusCode(!!$fs ? 200 : 403);
})->middleware(['auth', 'jaxon.dbadmin.config'])
    ->name('dbadmin.file');

Route::get('/audit', fn() => view('dbaudit', ['package' => DbAuditPackage::class]))
    ->middleware(['auth', 'jaxon.dbaudit.config'])
    ->name('dbaudit');

Route::post('/audit/jaxon', fn() => response()->json([]))
    ->middleware(['web', 'jaxon.dbaudit.config', 'jaxon.ajax'])
    ->name('dbaudit.jaxon');

// Logout
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout.get')->middleware('auth');

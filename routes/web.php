<?php

use Illuminate\Support\Facades\Route;
use Lagdo\DbAdmin\App\DbAdminPackage;
use Lagdo\DbAdmin\App\DbAuditPackage;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use function Jaxon\jaxon;

Route::get('/', fn() => view('dbadmin', ['package' => DbAdminPackage::class]))
    ->middleware(['auth', 'jaxon.dbadmin.config']);

Route::post('/jaxon', fn() => response()->json([]))
    ->middleware(['web', 'jaxon.dbadmin.config', 'jaxon.ajax'])
    ->name('dbadmin.jaxon');

Route::get('/export/{filename}', function(string $filename) {
    $reader = jaxon()->package(DbAdminPackage::class)->getOption('export.reader');
    $content = !is_callable($reader) ? "No export reader set." : $reader($filename);
    return response($content)->header('Content-Type', 'text/plain');
})->middleware(['auth', 'jaxon.dbadmin.config'])
    ->name('export_file');

Route::get('/audit', fn() => view('dbaudit', ['package' => DbAuditPackage::class]))
    ->middleware(['auth', 'jaxon.dbaudit.config'])
    ->name('dbaudit');

Route::post('/audit/jaxon', fn() => response()->json([]))
    ->middleware(['web', 'jaxon.dbaudit.config', 'jaxon.ajax'])
    ->name('dbaudit.jaxon');

// Logout
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout.get')->middleware('auth');

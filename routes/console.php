<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user:localdb', function () {
    $dbFile = config('database.connections.sqlite.database');
    if (!file_exists($dbFile)) {
        touch($dbFile);
    }
})->purpose('Create the local user database');

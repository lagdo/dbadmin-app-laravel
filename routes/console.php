<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user:localdb', function () {
    $dbFile = env('DB_DATABASE', database_path('dbadmin.sqlite'));
    if (!file_exists($dbFile)) {
        touch($dbFile);
    }
})->purpose('Create the local user database');

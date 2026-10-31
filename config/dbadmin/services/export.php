<?php

use Illuminate\Support\Str;
use Lagdo\DbAdmin\Support\Facade\Auth;
use Lagdo\DbAdmin\Support\Service\Export\AbstractFileSystem;

return [
    // 'default' => null, // No export.
    'default' => fn() => new class extends AbstractFileSystem {
        protected function storage(): string
        {
            return 'exports';
        }
        protected function path(string $filename): string
        {
            // Use the slugified username to customize the path.
            $userId = Auth::userId();
            $userDir = $userId === '' ? 'users' : 'users/' . Str::slug($userId);
            return "$userDir/$filename";
        }
        protected function url(string $filename): string
        {
            return route('dbadmin.file', ['filename' => $filename]);
        }
    },
];

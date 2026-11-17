<?php

use Illuminate\Support\Str;
use Lagdo\DbAdmin\Support\Facade\Auth;
use Lagdo\DbAdmin\Support\Service\Export;
use Lagdo\DbAdmin\Support\Service\Import;

return [
    // 'export' => null, // No export.
    'export' => fn() => new class extends Export\AbstractStorage {
        public function status(): array
        {
            return [
                // The path to a local directory
                // 'directory' => '',
                // A storage entry in the Jaxon config.
                // 'storage' => '',
            ];
        }
        public function path(string $filename): string
        {
            // Use the slugified username to customize the path.
            $userId = Auth::userId();
            $userDir = $userId === '' ? 'visitor' : Str::slug($userId);
            return "$userDir/$filename";
        }
        public function url(string $filename): string
        {
            return route('dbadmin.export', ['filename' => $filename]);
        }
    },

    // 'import' => null, // No import.
    'import' => fn() => new class extends Import\AbstractStorage {
        public function status(): array
        {
            return [
                // The path to a local directory
                // 'directory' => '',
                // A storage entry in the Jaxon config.
                // 'storage' => '',
            ];
        }
        public function path(string $filename): string
        {
            // Use the slugified username to customize the path.
            $userId = Auth::userId();
            $userDir = $userId === '' ? 'visitor' : Str::slug($userId);
            return "$userDir/$filename";
        }
        public function url(string $filename): string
        {
            return route('dbadmin.import', ['filename' => $filename]);
        }
        public function dumps(): array
        {
            return [
                // 'databases' => [
                //     // A label to be display in the select form.
                //     'label' => 'Database dumps',
                //     // The path to a local directory
                //     'directory' => '',
                //     // A storage entry in the Jaxon config.
                //     'storage' => '',
                // ],
            ];
        }
        public function dumpLabels(): array
        {
            return [];
        }
    },
];

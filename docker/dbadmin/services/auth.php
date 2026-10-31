<?php

use Illuminate\Support\Facades\Auth;
use Lagdo\DbAdmin\Support\Provider\AuthInterface;

return [
    // 'default' => null, // No auth.
    'default' => fn() => new class implements AuthInterface {
        public function userId(): string
        {
            return Auth::user()->email ?? '';
        }
        public function name(): string
        {
            return Auth::user()->name ?? '';;
        }
        public function roles(): array
        {
            return [];
        }
        public function audit(): string
        {
            return route('dbaudit');
        }
        public function logout(): string
        {
            return route('logout.get');
        }
    },
];

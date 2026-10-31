<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

use function jaxon;
use function view;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Login view
        Fortify::loginView(function() {
            $jaxon = jaxon();
            view()->share('builtWith', $jaxon->di()->g('built_with'));
            $template = $jaxon->getAppOption('template');
            return view("{$template}.auth.login");
        });

        RateLimiter::for('login', function (Request $request) {
            $username = $request->input(Fortify::username());
            $throttleKey = Str::transliterate(Str::lower($username).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}

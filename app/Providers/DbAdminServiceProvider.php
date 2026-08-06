<?php

namespace App\Providers;

use App\Models\User;
use Dotenv\Dotenv;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Jaxon\Laravel\App\Jaxon;
use Lagdo\DbAdmin\App\DbAuditPackage;
use Lagdo\DbAdmin\Driver\Utils\TranslatorInterface;
use Lagdo\DbAdmin\Support\Provider\AuthInterface;

use function base_path;
use function config;
use function in_array;

class DbAdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // The facade needs this to be defined.
        $this->app->singleton(AuthInterface::class, function(Application $app) {
            return $app->make(Jaxon::class)->di()->g(AuthInterface::class);
        });
        $this->app->singleton(TranslatorInterface::class, function(Application $app) {
            return $app->make(Jaxon::class)->di()->g(TranslatorInterface::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load the custom env file
        $dotenv = Dotenv::createImmutable(base_path(), '.env.dbadmin');
        $dotenv->safeLoad();

        // Auth gate for the DbAdmin audit page
        Gate::define('audit', fn(User $user) =>
            $this->app->make(Jaxon::class)->di()
                ->g(DbAuditPackage::class)->checkAccess($user->email));
    }
}

<?php

declare(strict_types=1);

namespace App\Providers;

use App;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // @TB: Opting Out Of Package Discovery
        // Be sure to set this as 'dont-discover' in composer.json
        // https://packagist.org/packages/barryvdh/laravel-ide-helper
        // https://laravel.com/docs/packages#package-discovery
        if (App::isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // @TB: See Migration Default String Length
        // https://laravel.com/docs/5.4/releases#laravel-5.4
        // https://laravel.com/docs/5.7/migrations#indexes
        $mySQLDBVersion = $this->getMySQLDBVersion();

        if ($mySQLDBVersion !== null && version_compare($mySQLDBVersion, '5.7.7') < 0) {
            Schema::defaultStringLength(191);
        }
    }

    private function getMySQLDBVersion()
    {
        if (DB::getName() !== 'mysql') {
            return null;
        }

        try {
            $results = DB::select('select version() as version');

            return $results[0]->version;
        } catch (QueryException $exception) {
            // Do nothing... db server may not yet be available
            // This typically happens during composer installation
            return null;
        }
    }
}

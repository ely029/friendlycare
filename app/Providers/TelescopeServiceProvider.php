<?php

declare(strict_types=1);

namespace App\Providers;

use App;
use Laravel\Telescope\Telescope;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // @TB: The majority voted dark theme.
        // (Currently no way to do auto from the backend. Ignition does it in
        // its CSS/JS.)
        if (config('ignition.theme') !== 'light') {
            Telescope::night();
        }

        $this->hideSensitiveRequestDetails();

        // @TB: Record all data in any environment for easier debugging.
        // Do not filter.
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     *
     * @return void
     */
    protected function hideSensitiveRequestDetails()
    {
        if (App::isLocal()) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [
                // @TB: ThinkBIT Support
                'support@thinkbitsolutions.com',
            ]);
        });
    }
}

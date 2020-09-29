<?php

return [

    // @TB: https://github.com/laravel/telescope/issues/347
    'enabled' => env('TELESCOPE_ENABLED', env('APP_ENV') !== 'testing'),

];

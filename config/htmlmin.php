<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Raza Mehdi <srmk@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Automatic Blade Optimizations
    |--------------------------------------------------------------------------
    |
    | This option enables minification of the blade views as they are
    | compiled. These optimizations have little impact on php processing time
    | as the optimizations are only applied once and are cached. This package
    | will do nothing by default to allow it to be used without minifying
    | pages automatically.
    |
    | Default: false
    |
    */

    // @TB: We want to check if minification does not break the app in other
    // testing environments.
    'blade' => env('APP_ENV') !== 'local',

    /*
    |--------------------------------------------------------------------------
    | Force Blade Optimizations
    |--------------------------------------------------------------------------
    |
    | This option forces blade minification on views where there such
    | minification may be dangerous. This should only be used if you are fully
    | aware of the potential issues this may cause. Obviously, this setting is
    | dependent on blade minification actually being enabled.
    |
    | PLEASE USE WITH CAUTION
    |
    | Default: false
    |
    */

    // @TB: We want to check if minification does not break the app in other
    // testing environments.
    'force' => env('APP_ENV') !== 'local',

];

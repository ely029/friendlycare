<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Editor
    |--------------------------------------------------------------------------
    |
    | Choose your preferred editor to use when clicking any edit button.
    |
    | Supported: "phpstorm", "vscode", "vscode-insiders",
    |            "sublime", "atom"
    |
    */

    // @TB: Company IDE.
    'editor' => env('IGNITION_EDITOR', 'vscode'),

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | Here you may specify which theme Ignition should use.
    |
    | Supported: "light", "dark", "auto"
    |
    */

    // @TB: The majority voted dark theme but let's respect the OS setting.
    'theme' => env('IGNITION_THEME', 'auto'),

    /*
    |--------------------------------------------------------------------------
    | Sharing
    |--------------------------------------------------------------------------
    |
    | You can share local errors with colleagues or others around the world.
    | Sharing is completely free and doesn't require an account on Flare.
    |
    | If necessary, you can completely disable sharing below.
    |
    */

    // @TB: Prevent accidental sharing of sensitive information.
    'enable_share_button' => env('IGNITION_SHARING_ENABLED', false),

];

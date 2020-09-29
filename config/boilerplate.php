<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Application description
   |--------------------------------------------------------------------------
   |
   | This value is the description of your application. This value is used
   | when the framework needs to place the application's description in the
   | web page or other location as required by the application.
   */

    'description' => 'The PHP Framework for Web Artisans.',

    'facebook_app_id' => env('BP_FB_APP_ID', ''),
    'twitter_site_id' => env('BP_TWITTER_APP_ID', ''),
    'itunes_app_id' => env('BP_ITUNES_APP_ID', ''),
    'google_analytics_tracking_id' => env('BP_GOOGLE_ANALYTICS_TRACKING_ID', ''),

    'membership' => true,

    'firebase' => [
        // This is normally the name of the app in snake case. E.g., `thinkbit`, `tb`, or `tb_journal`
        'notification_key_name_prefix' => env('BP_FIREBASE_NOTIFICATION_KEY_NAME_PREFIX'),

        'server_key' => env('BP_FIREBASE_SERVER_KEY'),
        'sender_id' => env('BP_FIREBASE_SENDER_ID'),
    ],
];

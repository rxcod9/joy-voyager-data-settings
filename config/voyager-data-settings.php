<?php

return [

    /*
     * If enabled for voyager-data-settings package.
     */
    'enabled' => env('VOYAGER_DATA_SETTINGS_ENABLED', true),

    /*
    | Here you can specify for which data type slugs data-settings is enabled
    | 
    | Supported: "*", or data type slugs "users", "roles"
    |
    */

    'allowed_slugs' => array_filter(explode(',', env('VOYAGER_DATA_SETTINGS_ALLOWED_SLUGS', '*'))),

    /*
    | Here you can specify for which data type slugs data-settings is not allowed
    | 
    | Supported: "*", or data type slugs "users", "roles"
    |
    */

    'not_allowed_slugs' => array_filter(explode(',', env('VOYAGER_DATA_SETTINGS_NOT_ALLOWED_SLUGS', ''))),

    /*
     * The config_key for voyager-data-settings package.
     */
    'config_key' => env('VOYAGER_DATA_SETTINGS_CONFIG_KEY', 'joy-voyager-data-settings'),

    /*
     * The route_prefix for voyager-data-settings package.
     */
    'route_prefix' => env('VOYAGER_DATA_SETTINGS_ROUTE_PREFIX', 'joy-voyager-data-settings'),

    /*
    |--------------------------------------------------------------------------
    | Controllers config
    |--------------------------------------------------------------------------
    |
    | Here you can specify voyager controller settings
    |
    */

    'controllers' => [
        'namespace' => 'Joy\\VoyagerDataSettings\\Http\\Controllers',
    ],
];

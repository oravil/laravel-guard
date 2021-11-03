<?php
// config for Oravil/LaravelGuard
return [
    // laravel guard version
    'version' => '1.0',

    /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    |
    | The default provider you would like to use for geo ip retrieval.
    |
    */

    'provider' => 'ip-api',

    /*
    |--------------------------------------------------------------------------
    | Driver Fallbacks
    |--------------------------------------------------------------------------
    |
    | The providers you want to use to retrieve the users geo ip
    | if the above selected driver is unavailable.
    |
    | These will be called upon in order (first to last).
    |
    */

    'fallbacks' => [
        Oravil\LaravelGuard\Providers\IpRegistry::class,
        Oravil\LaravelGuard\Providers\IpApi::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Location
    |--------------------------------------------------------------------------
    |
    | Here you may configure the position instance that is created
    | and returned from the above drivers. The instance you
    | create must extend the built-in Position class.
    |
    */

    'location' => Oravil\LaravelGuard\Support\Location::class,

    /*
    |--------------------------------------------------------------------------
    | Localhost Testing
    |--------------------------------------------------------------------------
    |
    | If your running your website locally and want to test different
    | IP addresses to see location detection, set 'enabled' to true.
    |
    | The testing IP address is a Google host in the United-States.
    |
    */

    'testing' => [
        'enabled'  => env('GUARD_TESTING', true),
        'valid_ip' => '102.189.209.97',
        'cloud_ip' => '108.162.193.194',
        'proxy_ip' => '193.176.86.46',
        'tor_ip'   => '103.236.201.88',
        'bogon_ip' => '203.0.113.24',
    ],

    'providers' => [ // providers list
        'ipregistry' => [  // ip registry https://ipregistry.co/docs/
            'class' => \Oravil\LaravelGuard\Providers\IpRegistry::class, //provider class path
            'api_key' => env('IPREGISTRY_API_KEY', ''), // api key
            'api_url' => 'https://api.ipregistry.co/', // api base url
            'currencies' => env('GUARD_CURRENCIES', true), // if you need currencies data
            'language' => env('GUARD_LANGUAGE', true), // if you need langauge data
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'iphub' => [ // ip hub https://iphub.info/
            'class' => \Oravil\LaravelGuard\Providers\IpHub::class, //provider class path
            'api_key' => env('IPHUB_API_KEY', ''), // api key
            'api_url' => 'http://v2.api.iphub.info/ip/', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'ip-api' => [ // ip api https://ip-api.com/
            'class' => \Oravil\LaravelGuard\Providers\IpApi::class, //provider class path
            'pro_api_url' => 'https://pro.ip-api.com/json/', // pro services
            'api_key' => env('IPAPI_API_KEY', null), // api key
            'api_url' => 'http://ip-api.com/json/', // api base url
            'currencies_enabled' => true, //  support currenices code only
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'proxycheck' => [ // ip api https://proxycheck.io/
            'class' => \Oravil\LaravelGuard\Providers\ProxyCheck::class, //provider class path
            'api_key' => env('PROXYCHECK_API_KEY', ''), // api key
            'api_url' => 'http://proxycheck.io/v2/', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
            'block_score' => 33
        ],

        'ipapicom' => [ // ip api https://ipapi.com/
            'class' => \Oravil\LaravelGuard\Providers\IpApiCom::class, //provider class path
            'api_key' => env('IPAPICOM_API_KEY', ''), // api key
            'api_url' => 'http://api.ipapi.com/api/', // api base url
            'security_enabled' => env('GUARD_SECURITY', false), //security status
            'security_plan_enable' => false, // if you plan is BUSINESS PRO
            'currency_plan_enable' => false, // if you plan is STANDARD or above
        ],

        'ipdata' => [ // ip data https://ipdata.co/
            'class' => \Oravil\LaravelGuard\Providers\IpData::class, //provider class path
            'api_key' => env('IPDATA_API_KEY', ''), // api key
            'api_url' => 'https://api.ipdata.co/', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'ipinfo' => [ // ip data https://ipdata.co/
            'class' => \Oravil\LaravelGuard\Providers\IpInfo::class, //provider class path
            'api_key' => env('IPINFO_API_KEY', ''), // api key
            'api_url' => '//ipinfo.io/', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'geoplugin' => [ // ip data http://www.geoplugin.net
            'class' => \Oravil\LaravelGuard\Providers\GeoPlugin::class, //provider class path
            'api_url' => 'http://www.geoplugin.net/json.gp?ip=', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],
    ],

];

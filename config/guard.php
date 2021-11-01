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

    'provider' => 'iphub',

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

    // providers list
    'providers' => [
        // ip registry https://ipregistry.co/docs/
        'ipregistry' => [
            //provider class path
            'class' => \Oravil\LaravelGuard\Providers\IpRegistry::class,
            // api key
            'api_key' => env('IPREGISTRY_API_KEY', 'tihw7k2wjdcwafv7'),
            // api base url
            'api_url' => 'https://api.ipregistry.co/',
            // if you need currencies data
            'currencies' => env('GUARD_CURRENCIES', true),
            // if you need langauge data
            'language' => env('GUARD_LANGUAGE', true),
            //security status
            'security_enabled' => env('GUARD_SECURITY', true),
            //if you need block via filtter
            'block_filters' => [
                // if you enable this filter if any filter got value ture will block the connection
                'any' => false,
                // Boolean indicating whether the IP address is used for hosting purposes
                // (e.g. a node from Akamai, Cloudflare, Google Cloud Platform, Amazon EC2, and more).
                'is_cloud_provider' => false,
                // whether the IP Address is a known source of abuse (e.g. spam, harvesters, registration bots).
                // Boolean indicating whether the IP Address is a known source of malicious activity
                // (e.g. attacks, malware, botnet activity).
                'is_threat' => false,
                // Boolean indicating whether the IP Address is a Tor relay: exit relay node, middle relay node or a bridge
                // whether the IP Address is a known proxy.It includes HTTP/HTTPS/SSL/SOCKS/CONNECT and transparent proxies.
                'is_anonymous' => false,
                // Boolean indicating whether the IP Address is a Bogon: an unassigned, unaddressable IP address.
                'is_bogon' => false,
            ]
        ],

        // ip hub https://iphub.info/
        'iphub' => [
            //provider class path
            'class' => \Oravil\LaravelGuard\Providers\IpHub::class,
            // api key
            'api_key' => env('IPHUB_API_KEY', 'MTU3NDc6YUV0Tzl2SmMxekZvTUtCbzNubmtnaHVvZ2NMTVF1ZmM='),
            // api base url
            'api_url' => 'http://v2.api.iphub.info/ip/',
            //security status
            'security_enabled' => env('GUARD_SECURITY', true),
        ],


        'ip-api' => [ // ip api https://ip-api.com/
            'class' => \Oravil\LaravelGuard\Providers\IpApi::class, //provider class path
            'pro_api_url' => 'https://pro.ip-api.com/json/', // pro services
            'api_key' => env('IP-API_API_KEY'), // api key
            'api_url' => 'http://ip-api.com/json/', // api base url
            'currencies_enabled' => true, //  support currenices code only
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],
    ],

];

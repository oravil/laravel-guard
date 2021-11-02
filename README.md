# laravel geo location, ip services, proxy and vpn detected

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oravil/laravel-guard.svg?style=flat-square)](https://packagist.org/packages/oravil/laravel-guard)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/oravil/laravel-guard/run-tests?label=tests)](https://github.com/oravil/laravel-guard/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/oravil/laravel-guard/Check%20&%20fix%20styling?label=code%20style)](https://github.com/oravil/laravel-guard/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/oravil/laravel-guard.svg?style=flat-square)](https://packagist.org/packages/oravil/laravel-guard)

---

# Package Support

-   [x] [laravel 8](https://laravel.com)
-   [x] [php 8](https://www.php.net/releases/8.0/en.php)
-   [x] [IpRegistry - api](https://ipregistry.co)
-   [x] [IpInfo - api](https://ipinfo.io)
-   [x] [IpData - api](https://ipdata.co)
-   [x] [Ip-Api - api](https://ip-api.com)
-   [x] [Ip-Api-Pro - api](https://ip-api.com)
-   [x] [IpApi.com - api](https://ipapi.com)
-   [x] [IpHub - api](https://iphub.info)
-   [x] [ProxyCheck - api](https://proxycheck.io)
-   [ ] [GeoPlugin - api](http://www.geoplugin.net)
-   [ ] [MaxMind - database](https://www.maxmind.com)
-   [ ] [MaxMind - api](https://www.maxmind.com)
-   [ ] [IpFinder - api](https://ipfinder.io)
-   [ ] [ipgeolocation - api ](https://ipgeolocation.io)

---

This package can be used to handle all ip services as a Laravel package. It Can Help With:

1. Determine the geographical location of website visitors based on their IP addresses
2. Detected Vpn, Proxy, Tor and Hosting Ip's.
3. retrieve Language, Currencies and Location Data.
4. Block Connections beside country, language and connection type.
5. Cache Ip data and storing in database.

## Support us

[buy me a coffee](https://paypal.me/AhmdYehia)

## Installation

You can install the package via composer:

```bash
composer require oravil/laravel-guard
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Oravil\LaravelGuard\LaravelGuardServiceProvider"
```

This is the contents of the published config file:

```php
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

    'location' => Oravil\LaravelGuard\Support\Location::class,

    /*
    |--------------------------------------------------------------------------
    | Localhost Testing
    |--------------------------------------------------------------------------
    |
    | If your running your website locally and want to test different
    | IP addresses to see location detection, set 'enabled' to true.
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
            'api_key' => env('IPREGISTRY_API_KEY', null), // api key
            'api_url' => 'https://api.ipregistry.co/', // api base url
            'currencies' => env('GUARD_CURRENCIES', true), // if you need currencies data
            'language' => env('GUARD_LANGUAGE', true), // if you need langauge data
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'iphub' => [ // ip hub https://iphub.info/
            'class' => \Oravil\LaravelGuard\Providers\IpHub::class, //provider class path
            'api_key' => env('IPHUB_API_KEY', null), // api key
            'api_url' => 'http://v2.api.iphub.info/ip/', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'ip-api' => [ // ip api https://ip-api.com/
            'class' => \Oravil\LaravelGuard\Providers\IpApi::class, //provider class path
            'pro_api_url' => 'https://pro.ip-api.com/json/', // pro services
            'api_key' => env('IP-API_API_KEY'), // api key
            'api_url' => 'http://ip-api.com/json/', // api base url
            'currencies_enabled' => true, //  support currenices code only
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'proxycheck' => [ // ip api https://proxycheck.io/
            'class' => \Oravil\LaravelGuard\Providers\ProxyCheck::class, //provider class path
            'api_key' => env('PROXYCHECK_API_KEY', null), // api key
            'api_url' => 'http://proxycheck.io/v2/', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
            'block_score' => 33
        ],

        'ipapicom' => [ // ip api https://ipapi.com/
            'class' => \Oravil\LaravelGuard\Providers\IpApiCom::class, //provider class path
            'api_key' => env('IPAPICOM_API_KEY', null), // api key
            'api_url' => 'http://api.ipapi.com/api/', // api base url
            'security_enabled' => env('GUARD_SECURITY', false), //security status
            'security_plan_enable' => false, // if you plan is BUSINESS PRO
            'currency_plan_enable' => false, // if you plan is STANDARD or above
        ],

        'ipdata' => [ // ip data https://ipdata.co/
            'class' => \Oravil\LaravelGuard\Providers\IpData::class, //provider class path
            'api_key' => env('IPDATA_API_KEY', null), // api key
            'api_url' => 'https://api.ipdata.co/', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'ipinfo' => [ // ip data https://ipdata.co/
            'class' => \Oravil\LaravelGuard\Providers\IpInfo::class, //provider class path
            'api_key' => env('IPINFO_API_KEY', null), // api key
            'api_url' => '//ipinfo.io/', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],
    ],
];
```

## Usage

```php
$guard = new Oravil\LaravelGuard();
echo $guard->get('8.8.8.8'); // get location instance
echo $guard->echoApiResponse('8.8.8.8'); // get request from api

#global functions
echo getIp('8.8.8.8'); // call $guard->get();
echo getApi('8.8.8.8'); // call $guard->getApi();
```

## Testing

```bash
composer test
```

## Todo

-   [x] add api service providers.
-   [x] push to Github
-   [x] push Pre-release
-   [x] add to Packagist
-   [ ] add cache driver.
-   [ ] add database driver.
-   [ ] block connections via filters.
-   [ ] add github documentation.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Thanks To:

-   [Torann](https://github.com/Torann/laravel-geoip)
-   [Stevebauman](https://github.com/stevebauman/location)

## Credits

-   [AhmdYehia](https://github.com/oravil)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

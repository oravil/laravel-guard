# laravel geo location, ip services, proxy and vpn detected

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oravil/laravel-guard.svg?style=flat-square)](https://packagist.org/packages/oravil/laravel-guard)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/oravil/laravel-guard/Check%20&%20fix%20styling?label=code%20style)](https://github.com/oravil/laravel-guard/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/oravil/laravel-guard.svg?style=flat-square)](https://packagist.org/packages/oravil/laravel-guard)
[![Donate](https://img.shields.io/packagist/v/oravil/laravel-guard.svg?style=flat-square)](https://paypal.me/AhmdYehia)

---

# Package Support

-   [x] [laravel 8](https://laravel.com)
-   [x] [php 8](https://www.php.net/releases/8.0/en.php)
-   [x] [IpRegistry ](https://ipregistry.co)
-   [x] [IpInfo](https://ipinfo.io)
-   [x] [IpData](https://ipdata.co)
-   [x] [Ip-Api](https://ip-api.com)
-   [x] [Ip-Api-Pro](https://ip-api.com)
-   [x] [IpApi.com](https://ipapi.com)
-   [x] [IpHub](https://iphub.info)
-   [x] [ProxyCheck](https://proxycheck.io)
-   [x] [GeoPlugin](http://www.geoplugin.net)
-   [x] [ipgeolocation](https://ipgeolocation.io)
-   [ ] [MaxMind - database](https://www.maxmind.com)
-   [ ] [MaxMind - api](https://www.maxmind.com)

## Providers Features

|   Provider    | Require Api | Free Limit |    Paid Limit    | Support Languages | Support Security | Support Currenices | Support Location |
| :-----------: | :---------: | :--------: | :--------------: | :---------------: | :--------------: | :----------------: | :--------------: |
|     IpHub     |      ✔      |   1k/day   |  up to 200k/day  |        ❌         |        ❌        |         ❌         |        ✔         |
|  IpRegistry   |      ✔      | 100k/once  | Per Paid Package |         ✔         |        ✔         |         ✔          |        ✔         |
|    Ip-Api     |     ❌      | 45/minute  |    unlimited     |        ❌         |        ✔         |         ❌         |        ✔         |
|    IpInfo     |      ✔      | 50k/month  | up to 2.5m/month |        ❌         |        ✔         |         ❌         |        ✔         |
|    IpData     |      ✔      |  1.5k/day  |  up to 100k/day  |         ✔         |        ✔         |         ✔          |        ✔         |
|   IpApi.com   |      ✔      |  1k/month  |  up to 2m/month  |         ✔         |        ✔         |         ✔          |        ✔         |
|  ProxyCheck   |     ❌      |   1k/day   |  up to 10m/day   |        ❌         |        ✔         |         ❌         |        ✔         |
|   GeoPlugin   |     ❌      |  Unknown   |        ❌        |        ❌         |        ❌        |         ✔          |        ✔         |
| IpGeoLocation |      ✔      |   1k/day   | up to 20m/month  |         ✔         |        ❌        |         ✔          |        ✔         |

---

This package can be used to handle all ip services as a Laravel package. It Can Help With:

1. Determine the geographical location of website visitors based on their IP addresses
2. Detected Vpn, Proxy, Tor and Hosting Ip's.
3. retrieve Language, Currencies and Location Data.
4. Block Connections beside country, language and connection type.(dev)
5. Cache Ip data and storing in database.(dev)

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
// config for Oravil/LaravelGuard config/guard.php
return [
    // laravel guard version
    'version' => '1.0',

    /*
    |-------------------------------------------------------------------------
    | Cache Driver
    | To use cache tags you should support one of cache drivers Redis / Memcached / Array
    |-------------------------------------------------------------------------
     *
     */

    'cache_enable' => false, // set true to enable cache

    'cache_tag_name' => 'lg-location', // cache tag name

    'cache_expires' => 30, // seconds

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
        'enabled'  => env('GUARD_TESTING', false),
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
            'api_key' => env('IPAPI_API_KEY', null), // api key
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

        'geoplugin' => [ // ip data http://www.geoplugin.net
            'class' => \Oravil\LaravelGuard\Providers\GeoPlugin::class, //provider class path
            'api_url' => 'http://www.geoplugin.net/json.gp?ip', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],

        'ipgeolocation' => [ // ip data https://ipgeolocation.io
            'class' => \Oravil\LaravelGuard\Providers\IpGeoLocation::class, //provider class path
            'api_key' => env('IP_GEO_LOCATION_API_KEY', null), // api key
            'api_url' => 'https://api.ipgeolocation.io/ipgeo', // api base url
            'security_enabled' => env('GUARD_SECURITY', true), //security status
        ],
    ],

];
```

## Usage

```php
#global functions
echo getIp();                                    // get location instance for client ip | testing ip if testing_enable => true
echo getIp('8.8.8.8');                           // LaravelGuard::get('8.8.8.8');
echo laravelGuard('8.8.8.8');                    // LaravelGuard::get('8.8.8.8');
echo laravelGuard()->echoApiResponse('8.8.8.8'); // LaravelGuard::echoApiResponse('8.8.8.8');
echo laravelGuard()->echoApiResponse();          // LaravelGuard::echoApiResponse('8.8.8.8');
echo laravelGuard()->testing('type');            // testing connection type(valid, proxy, vpn, tor, cloud, bogon), default: valid
laravelGuard()->flushCache();                    // flushed locations cache
//laravel facade
use Oravi/LaravelGuard/Facades/LaravelGuard;
echo LaravelGuard::get();                        // get location instance for client ip | testing ip if testing_enable => true
echo LaravelGuard::get('8.8.8.8');               // get location instance
echo LaravelGuard::echoApiResponse('8.8.8.8');   // get request from api for client ip
echo LaravelGuard::echoApiResponse();   // get request from api for client ip | testing ip if testing_enable => true
echo LaravelGuard::testing('type');              // testing connection type(valid, proxy, vpn, tor, cloud, bogon), default: valid
LaravelGuard::flushCache();                      // flushed locations cache

```

## Testing

```php
// testing using ipregistry provider
return laravelGuard()->testing(); // or laravelGuard()->testing('valid');
//output: {"ip":"102.189.209.97","countryName":"Egypt","countryCode":"EG","regionCode":"EG-C","regionName":"Al Q\u0101hirah","cityName":"Cairo","zipCode":"09893","latitude":"30.07795","longitude":"31.28525","areaCode":1001450,"isEU":false,"currencyStatus":true,"currencyName":"Egyptian Pound","currencyCode":"EGP","currencySymbol":"EGP","langStatus":true,"langName":"Arabic","langNative":"\u0627\u0644\u0639\u0631\u0628\u064a\u0629","langCode":"ar","timeZone":"Africa\/Cairo","currentTime":"2021-11-05T06:57:33+02:00","securityStatus":true,"isCloudProvider":false,"isThreat":false,"isAnonymous":false,"isBogon":false,"provider":"IpRegistry","provider_class":"Oravil\\LaravelGuard\\Providers\\IpRegistry","isCached":null}

return laravelGuard()->testing('cloud');
// output: {"ip":"108.162.193.194","countryName":"United States","countryCode":"US","regionCode":null,"regionName":null,"cityName":null,"zipCode":null,"latitude":"37.75096","longitude":"-97.822","areaCode":9629091,"isEU":false,"currencyStatus":true,"currencyName":"US Dollar","currencyCode":"USD","currencySymbol":"$","langStatus":true,"langName":"English","langNative":"English","langCode":"en","timeZone":"America\/Chicago","currentTime":"2021-11-04T23:59:59-05:00","securityStatus":true,"isCloudProvider":true,"isThreat":false,"isAnonymous":false,"isBogon":false,"provider":"IpRegistry","provider_class":"Oravil\\LaravelGuard\\Providers\\IpRegistry","isCached":null}

return laravelGuard()->testing('proxy'); // or laravelGuard()->testing('vpn');
//output: {"ip":"193.176.86.46","countryName":"Germany","countryCode":"DE","regionCode":"DE-BE","regionName":"Berlin","cityName":"Berlin","zipCode":"10178","latitude":"52.51965","longitude":"13.40687","areaCode":357021,"isEU":true,"currencyStatus":true,"currencyName":"Euro","currencyCode":"EUR","currencySymbol":"\u20ac","langStatus":true,"langName":"German","langNative":"Deutsch","langCode":"de","timeZone":"Europe\/Berlin","currentTime":"2021-11-05T06:00:43+01:00","securityStatus":true,"isCloudProvider":false,"isThreat":true,"isAnonymous":false,"isBogon":false,"provider":"IpRegistry","provider_class":"Oravil\\LaravelGuard\\Providers\\IpRegistry","isCached":null}

return laravelGuard()->testing('tor')
//output: {"ip":"103.236.201.88","countryName":"Indonesia","countryCode":"ID","regionCode":"ID-BT","regionName":"Banten","cityName":"Tangerang","zipCode":null,"latitude":"-6.17836","longitude":"106.63184","areaCode":1919440,"isEU":false,"currencyStatus":true,"currencyName":"Indonesian Rupiah","currencyCode":"IDR","currencySymbol":"IDR","langStatus":true,"langName":"Indonesian","langNative":"Indonesia","langCode":"id","timeZone":"Asia\/Jakarta","currentTime":"2021-11-05T12:02:37+07:00","securityStatus":true,"isCloudProvider":true,"isThreat":true,"isAnonymous":true,"isBogon":false,"provider":"IpRegistry","provider_class":"Oravil\\LaravelGuard\\Providers\\IpRegistry","isCached":null}

return laravelGuard()->testing('bogon')
//output: {"ip":"203.0.113.24","countryName":null,"countryCode":null,"regionCode":null,"regionName":null,"cityName":null,"zipCode":null,"latitude":"-4.0E-5","longitude":"4.0E-5","areaCode":0,"isEU":false,"currencyStatus":true,"currencyName":null,"currencyCode":null,"currencySymbol":null,"langStatus":true,"langName":null,"langNative":null,"langCode":null,"timeZone":"Africa\/Sao_Tome","currentTime":"2021-11-05T05:03:28Z","securityStatus":true,"isCloudProvider":false,"isThreat":true,"isAnonymous":false,"isBogon":true,"provider":"IpRegistry","provider_class":"Oravil\\LaravelGuard\\Providers\\IpRegistry","isCached":null}
```

# Flushed locations cache

// console

```bash
php artisan guard:flush
```

//php

```php
return laravelGuard()->flushCache();
```

## Todo

-   [x] add api service providers.
-   [x] push to Github
-   [x] push Pre-release
-   [x] add to Packagist
-   [x] add cache driver
-   [x] add cache flush console command
-   [x] add global functions
-   [x] push version 1.1
-   [ ] add fallbacks for limit requests
-   [ ] add database driver
-   [ ] add create custom provider console command
-   [ ] push version 1.2
-   [ ] block connections via filters
-   [ ] add github documentation
-   [ ] push version 1.3
-   [ ] push stable release

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

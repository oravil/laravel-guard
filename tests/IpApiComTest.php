<?php

use Illuminate\Support\Facades\Config;
use Oravil\LaravelGuard\Support\Location;

it('can fetch test ip from ipapicom provider', function () {
    Config::set('guard.provider', 'ipapicom');
    $ping = getIp(config('guard.testing.valid_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->and($ping->countryCode)->toEqual('EG')
        ->and($ping->countryName)->toEqual('Egypt');
});


it('can fetch cloud test ip from ipapicom provider', function () {
    Config::set('guard.provider', 'ipapicom');
    $ping = getIp(config('guard.testing.cloud_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->and($ping->countryCode)->toEqual('US')
        ->and($ping->countryName)->toEqual('United States');
});

it('can fetch proxy test ip from ipapicom provider', function () {
    Config::set('guard.provider', 'ipapicom');
    $ping = getIp(config('guard.testing.proxy_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->and($ping->countryCode)->toEqual('DE')
        ->and($ping->countryName)->toEqual('Germany');
});

it('can fetch tor test ip from ipapicom provider', function () {
    Config::set('guard.provider', 'ipapicom');
    $ping = getIp(config('guard.testing.tor_ip'));
    expect($ping)
        ->and($ping->countryCode)->toEqual('ID')
        ->and($ping->countryName)->toEqual('Indonesia');
});



// it('get api response', function () {
//     Config::set('guard.provider', 'ipapicom');
//     $ping = getApi(config('guard.testing.cloud_ip'));
//     dd($ping);
// });

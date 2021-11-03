<?php

use Illuminate\Support\Facades\Config;
use Oravil\LaravelGuard\Support\Location;

it('can fetch test ip from ipinfo provider', function () {
    Config::set('guard.provider', 'ipinfo');
    $ping = getIp(config('guard.testing.valid_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeFalse(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeFalse()
        )
        ->and($ping->countryCode)->toEqual('EG')
        ->and($ping->countryName)->toEqual('EG');
});


it('can fetch cloud test ip from ipinfo provider', function () {
    Config::set('guard.provider', 'ipinfo');
    $ping = getIp(config('guard.testing.cloud_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeTrue(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeFalse()
        )
        ->and($ping->countryCode)->toEqual('US')
        ->and($ping->countryName)->toEqual('US');
});

it('can fetch proxy test ip from ipinfo provider', function () {
    Config::set('guard.provider', 'ipinfo');
    $ping = getIp(config('guard.testing.proxy_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeFalse(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeTrue()
        )
        ->and($ping->countryCode)->toEqual('DE')
        ->and($ping->countryName)->toEqual('DE');
});

it('can fetch tor test ip from ipinf oprovider', function () {
    Config::set('guard.provider', 'ipinfo');
    $ping = getIp(config('guard.testing.tor_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeTrue(),
            fn ($ping) => $ping->isAnonymous->toBeTrue(),
            fn ($ping) => $ping->isThreat->toBeTrue()
        )
        ->and($ping->countryCode)->toEqual('ID')
        ->and($ping->countryName)->toEqual('ID');
});

it('check defualt provider is ipinfo', function () {
    Config::set('guard.provider', 'ipinfo');
    $provider = config('guard.provider');
    expect($provider)->toEqual('ipinfo');
});

// it('get api response', function () {
//     Config::set('guard.provider', 'ipinfo');
//     $ping = getApi(config('guard.testing.cloud_ip'));
//     dd($ping);
// });

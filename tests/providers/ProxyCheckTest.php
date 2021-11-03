<?php

use Illuminate\Support\Facades\Config;
use Oravil\LaravelGuard\Support\Location;

it('can fetch test ip from proxycheck provider', function () {
    Config::set('guard.provider', 'proxycheck');
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
        ->and($ping->countryName)->toEqual('Egypt');
});


it('can fetch cloud test ip from proxycheck provider', function () {
    Config::set('guard.provider', 'proxycheck');
    $ping = getIp(config('guard.testing.cloud_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeFalse(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeFalse()
        )
        ->and($ping->countryCode)->toEqual('US')
        ->and($ping->countryName)->toEqual('United States');
});

it('can fetch proxy test ip from proxycheck provider', function () {
    Config::set('guard.provider', 'proxycheck');
    $ping = getIp(config('guard.testing.proxy_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeFalse(),
            fn ($ping) => $ping->isAnonymous->toBeTrue(),
            fn ($ping) => $ping->isThreat->toBeTrue()
        )
        ->and($ping->countryCode)->toEqual('DE')
        ->and($ping->countryName)->toEqual('Germany');
});

it('can fetch tor test ip from proxycheck provider', function () {
    Config::set('guard.provider', 'proxycheck');
    $ping = getIp(config('guard.testing.tor_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeFalse(),
            fn ($ping) => $ping->isAnonymous->toBeTrue(),
            fn ($ping) => $ping->isThreat->toBeTrue()
        )
        ->and($ping->countryCode)->toEqual('ID')
        ->and($ping->countryName)->toEqual('Indonesia');
});



// it('get api response', function () {
//     Config::set('guard.provider', 'proxycheck');
//     $ping = getApi(config('guard.testing.valid_ip'));
//     dd($ping);
// });

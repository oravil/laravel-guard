<?php

use Illuminate\Support\Facades\Config;
use Oravil\LaravelGuard\Support\Location;

it('can fetch test ip from ipgeolocation provider', function () {
    Config::set('guard.provider', 'ipgeolocation');
    $ping = getIp(config('guard.testing.valid_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('Egyptian Pound'),
            fn ($ping) => $ping->currencyCode->toEqual('EGP'),
            fn ($ping) => $ping->currencySymbol->toEqual('EGP'),
        )
        ->and($ping->countryCode)->toEqual('EG')
        ->and($ping->countryName)->toEqual('Egypt');
});


it('can fetch cloud test ip from ipgeolocation provider', function () {
    Config::set('guard.provider', 'ipgeolocation');
    $ping = getIp(config('guard.testing.cloud_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('US Dollar'),
            fn ($ping) => $ping->currencyCode->toEqual('USD'),
            fn ($ping) => $ping->currencySymbol->toEqual('$'),
        )
        ->and($ping->countryCode)->toEqual('US')
        ->and($ping->countryName)->toEqual('United States');
});

it('can fetch proxy test ip from ipgeolocation provider', function () {
    Config::set('guard.provider', 'ipgeolocation');
    $ping = getIp(config('guard.testing.proxy_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('Euro'),
            fn ($ping) => $ping->currencyCode->toEqual('EUR'),
            fn ($ping) => $ping->currencySymbol->toEqual('€'),
        )
        ->and($ping->countryCode)->toEqual('DE')
        ->and($ping->countryName)->toEqual('Germany');
});

it('can fetch tor test ip from ipgeolocation provider', function () {
    Config::set('guard.provider', 'ipgeolocation');
    $ping = getIp(config('guard.testing.tor_ip'));
    expect($ping)
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('Indonesian Rupiah'),
            fn ($ping) => $ping->currencyCode->toEqual('IDR'),
            fn ($ping) => $ping->currencySymbol->toEqual('IDR'),
        )
        ->and($ping->countryCode)->toEqual('ID')
        ->and($ping->countryName)->toEqual('Indonesia');
});



// it('get api response', function () {
//     Config::set('guard.provider', 'ipgeolocation');
//     $ping = getApi(config('guard.testing.valid_ip'));
//     dd($ping);
// });

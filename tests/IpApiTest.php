<?php

use Illuminate\Support\Facades\Config;
use Oravil\LaravelGuard\Support\Location;

it('can fetch test ip from ip-api provider', function () {
    Config::set('guard.provider', 'ip-api');
    $ping = getIp(config('guard.testing.valid_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeFalse(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isBogon->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeFalse()
        )
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('EGP'),
            fn ($ping) => $ping->currencyCode->toEqual('EGP'),
            fn ($ping) => $ping->currencySymbol->toEqual('EGP'),
        )
        ->and($ping->countryCode)->toEqual('EG')
        ->and($ping->countryName)->toEqual('Egypt');
});


it('can fetch cloud test ip from ip-api provider', function () {
    Config::set('guard.provider', 'ip-api');
    $ping = getIp(config('guard.testing.cloud_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeTrue(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isBogon->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeFalse()
        )
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('USD'),
            fn ($ping) => $ping->currencyCode->toEqual('USD'),
            fn ($ping) => $ping->currencySymbol->toEqual('USD'),
        )
        ->and($ping->countryCode)->toEqual('US')
        ->and($ping->countryName)->toEqual('United States');
});

it('can fetch proxy test ip from ip-api provider', function () {
    Config::set('guard.provider', 'ip-api');
    $ping = getIp(config('guard.testing.proxy_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeTrue(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isBogon->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeTrue()
        )
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('EUR'),
            fn ($ping) => $ping->currencyCode->toEqual('EUR'),
            fn ($ping) => $ping->currencySymbol->toEqual('EUR'),
        )
        ->and($ping->countryCode)->toEqual('DE')
        ->and($ping->countryName)->toEqual('Germany');
});

it('can fetch tor test ip from ip-api provider', function () {
    Config::set('guard.provider', 'ip-api');
    $ping = getIp(config('guard.testing.tor_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeTrue(),
            fn ($ping) => $ping->isAnonymous->toBeTrue(),
            fn ($ping) => $ping->isBogon->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeTrue()
        )
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('IDR'),
            fn ($ping) => $ping->currencyCode->toEqual('IDR'),
            fn ($ping) => $ping->currencySymbol->toEqual('IDR'),
        )
        ->and($ping->countryCode)->toEqual('ID')
        ->and($ping->countryName)->toEqual('Indonesia');
});

it('can fetch bogon test ip from ip-api provider', function () {
    Config::set('guard.provider', 'ip-api');
    $ping = getIp(config('guard.testing.bogon_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeFalse(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isBogon->toBeTrue(),
            fn ($ping) => $ping->isThreat->toBeTrue()
        )
        ->and($ping->countryCode)->toEqual('US')
        ->and($ping->countryName)->toEqual('United States');
});

it('check defualt provider is ip-api', function () {
    Config::set('guard.provider', 'ip-api');
    $provider = config('guard.provider');
    expect($provider)->toEqual('ip-api');
});

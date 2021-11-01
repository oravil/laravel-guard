<?php

use Illuminate\Support\Facades\Config;
use Oravil\LaravelGuard\Support\Location;

it('can fetch test ip from ipRegistry provider', function () {
    Config::set('guard.provider', 'ipregistry');
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
            fn ($ping) => $ping->currencyName->toEqual('Egyptian Pound'),
            fn ($ping) => $ping->currencyCode->toEqual('EGP'),
            fn ($ping) => $ping->currencySymbol->toEqual('EGP'),
        )
        ->when(
            $ping->langStatus,
            fn ($ping) => $ping->langName->toEqual('Arabic'),
            fn ($ping) => $ping->langCode->toEqual('ar'),
        )
        ->and($ping->countryCode)->toEqual('EG')
        ->and($ping->countryName)->toEqual('Egypt');
});


it('can fetch cloud test ip from ipRegistry provider', function () {
    Config::set('guard.provider', 'ipregistry');
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
            fn ($ping) => $ping->currencyName->toEqual('US Dollar'),
            fn ($ping) => $ping->currencyCode->toEqual('USD'),
            fn ($ping) => $ping->currencySymbol->toEqual('$'),
        )
        ->when(
            $ping->langStatus,
            fn ($ping) => $ping->langName->toEqual('English'),
            fn ($ping) => $ping->langCode->toEqual('en'),
        )
        ->and($ping->countryCode)->toEqual('US')
        ->and($ping->countryName)->toEqual('United States');
});

it('can fetch proxy test ip from ipRegistry provider', function () {
    Config::set('guard.provider', 'ipregistry');
    $ping = getIp(config('guard.testing.proxy_ip'));
    expect($ping)
        ->toBeInstanceOf(Location::class)
        ->when(
            $ping->securityStatus,
            fn ($ping) => $ping->isCloudProvider->toBeFalse(),
            fn ($ping) => $ping->isAnonymous->toBeFalse(),
            fn ($ping) => $ping->isBogon->toBeFalse(),
            fn ($ping) => $ping->isThreat->toBeTrue()
        )
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toEqual('Euro'),
            fn ($ping) => $ping->currencyCode->toEqual('EUR'),
            fn ($ping) => $ping->currencySymbol->toEqual('€'),
        )
        ->when(
            $ping->langStatus,
            fn ($ping) => $ping->langName->toEqual('German'),
            fn ($ping) => $ping->langCode->toEqual('de'),
        )
        ->and($ping->countryCode)->toEqual('DE')
        ->and($ping->countryName)->toEqual('Germany');
});

it('can fetch tor test ip from ipRegistry provider', function () {
    Config::set('guard.provider', 'ipregistry');
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
            fn ($ping) => $ping->currencyName->toEqual('Indonesian Rupiah'),
            fn ($ping) => $ping->currencyCode->toEqual('IDR'),
            fn ($ping) => $ping->currencySymbol->toEqual('IDR'),
        )
        ->when(
            $ping->langStatus,
            fn ($ping) => $ping->langName->toEqual('Indonesian'),
            fn ($ping) => $ping->langCode->toEqual('id'),
        )
        ->and($ping->countryCode)->toEqual('ID')
        ->and($ping->countryName)->toEqual('Indonesia');
});

it('can fetch bogon test ip from ipRegistry provider', function () {
    Config::set('guard.provider', 'ipregistry');
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
        ->when(
            $ping->currencyStatus,
            fn ($ping) => $ping->currencyName->toBeNull(),
            fn ($ping) => $ping->currencyCode->toBeNull(),
            fn ($ping) => $ping->currencySymbol->toBeNull(),
        )
        ->when(
            $ping->langStatus,
            fn ($ping) => $ping->langName->toBeNull(),
            fn ($ping) => $ping->langCode->toBeNull(),
        )
        ->and($ping->countryCode)->toBeNull()
        ->and($ping->countryName)->toBeNull();
});

it('check defualt provider is ipRegistry', function () {
    Config::set('guard.provider', 'ipregistry');
    $provider = config('guard.provider');
    expect($provider)->toEqual('ipregistry');
});

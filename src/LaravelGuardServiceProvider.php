<?php

namespace Oravil\LaravelGuard;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Oravil\LaravelGuard\Commands\LaravelGuardCommand;

class LaravelGuardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-guard')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-guard_table')
            ->hasCommand(LaravelGuardCommand::class);
    }
}

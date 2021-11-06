<?php

namespace Oravil\LaravelGuard;

use Illuminate\Contracts\Http\Kernel;
use Oravil\LaravelGuard\Commands\LaravelGuardCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasCommand(LaravelGuardCommand::class)
            ->hasConfigFile('guard');
    }

    public function packageRegistered()
    {
        $this->app->singleton('laravelGuard', function ($app) {
            return new LaravelGuard($app->config->get('guard'));
        });
    }

    public function packageBooted()
    {
        LaravelGuard::setCacheInstance($this->app['cache']);
    }
}

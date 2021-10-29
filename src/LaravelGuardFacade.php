<?php

namespace Oravil\LaravelGuard;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Oravil\LaravelGuard\LaravelGuard
 */
class LaravelGuardFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-guard';
    }
}

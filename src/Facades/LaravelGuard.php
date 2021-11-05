<?php

namespace Oravil\LaravelGuard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Oravil\LaravelGuard\LaravelGuard
 */
class LaravelGuard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravelGuard';
    }
}

<?php

namespace Oravil\LaravelGuard\Exceptions;

class ProviderDoseNotExist extends LocationException
{
    /**
     * Create a new exception for the non-existent provider.
     *
     * @param string $provider
     *
     * @return static
     */
    public static function forProvider($provider)
    {
        return new static(
            "The provider class [$provider] does not exist. Did you publish the configuration file?"
        );
    }
}

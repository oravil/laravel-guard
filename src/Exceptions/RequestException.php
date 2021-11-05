<?php

namespace Oravil\LaravelGuard\Exceptions;

class RequestException extends LocationException
{
    /**
     * Create a new exception for the non-existent provider.
     *
     * @param string $provider
     *
     * @return static
     */
    public static function forFailedRequest($url, $err_status, $err_code = null, $err_message = null)
    {
        return new static(
            "The Request From [$url] has failed with status code: $err_status , Message: \"$err_message\" ,
            $err_code"
        );
    }
}

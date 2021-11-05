<?php

if (! function_exists('getIp')) {
    /**
     * Get the location of the provided IP.
     *
     * @param string $ip
     *
     * @return \Oravil\LaravelGuard\Support\Location
     */
    function getIp($ip = null)
    {
        return app('laravelGuard')->get($ip);
    }
}

if (! function_exists('laravelGuard')) {
    /**
     * Get the location of the provided IP.
     *
     * @param string $ip
     *
     * @return json|\Oravil\LaravelGuard\Support\Location
     */
    function laravelGuard($ip = null)
    {
        if (is_null($ip)) {
            return app('laravelGuard');
        }

        return app('laravelGuard')->get($ip);
    }
}

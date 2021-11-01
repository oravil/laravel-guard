<?php

if (!function_exists('getIp')) {
    /**
     * Get the location of the provided IP.
     *
     * @param string $ip
     *
     * @return \Oravil\LaravelGuard\LaravelGuard|\Oravil\LaravelGuard\Support\Location
     */
    function getIp($ip = null)
    {
        if (is_null($ip)) {
            return app('laravelGuard')->get();
        }

        return app('laravelGuard')->get($ip);
    }
}

<?php

namespace Oravil\LaravelGuard\Providers;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Http;
use Oravil\LaravelGuard\Support\Location;
use Oravil\LaravelGuard\Exceptions\RequestException;

abstract class Provider
{
    protected $securityEnabled = false;
    protected $currencyEnabled = false;
    protected $langEnabled = false;


    /**
     * Create a new GeoIP instance.
     *
     * @param array        $config
     */
    public function __construct(protected array $config)
    {
        $this->config = $config;
        $this->securityEnabled = $this->config('security_enabled');
        $this->currencyEnabled = $this->config('currencies_enabled');
        $this->langEnabled = $this->config('language_enabled');
    }



    /**
     * The fallback provider.
     *
     * @var Provider
     */
    protected $fallback;

    /**
     * Append a fallback provider to the end of the chain.
     *
     * @param Provider $handler
     */
    public function fallback(Provider $handler)
    {
        if (is_null($this->fallback)) {
            $this->fallback = $handler;
        } else {
            $this->fallback->fallback($handler);
        }
    }

    /**
     * Handle the provider request.
     *
     * @param string $ip
     *
     * @return Location|bool
     */
    public function get($ip)
    {
        $data = $this->process($ip);
        $location = $this->getNewLocation();
        // Here we will ensure the geo data we received isn't empty.
        // Some IP location providers will return empty JSON. We want
        // to avoid this so we can go to a fallback provider.
        if ($data instanceof Fluent && $this->fluentDataIsNotEmpty($data)) {
            $location = $this->hydrate($location, $data);
            $location->ip = $ip;
            $location->provider_class = get_class($this);
            $location->provider = substr(strrchr(get_class($this), "\\"), 1);
            $location->securityStatus = $this->securityEnabled;
            $location->langStatus = $this->langEnabled;
            $location->currencyStatus = $this->currencyEnabled;
        }

        if (!$location->isEmpty()) {
            return $location;
        }

        return $this->fallback ? $this->fallback->get($ip) : false;
    }

    /**
     * Attempt to fetch and process the location data from the provider.
     *
     * @param string $ip
     *
     * @return Fluent|bool
     */
    protected function process($ip)
    {
        try {
            $response = json_decode($this->getUrlContent($ip), true);
            return new Fluent($response);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Create a new location instance.
     *
     * @return Location
     */
    protected function getNewLocation()
    {
        $location = config('guard.location', Location::class);
        return new $location;
    }

    /**
     * Determine if the given fluent data is not empty.
     *
     * @param Fluent $data
     *
     * @return bool
     */
    protected function fluentDataIsNotEmpty(Fluent $data)
    {
        return !empty(array_filter($data->getAttributes()));
    }


    /**
     * Get configuration value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * Hydrate the Location object with the given location data.
     *
     * @param Location $location
     * @param Fluent   $data
     *
     * @return Oravil\LaravelGuard\Support\Location
     */
    abstract protected function hydrate(Location $location, Fluent $data);

    /**
     * Get content from the given URL using cURL.
     *
     * @param string $url
     *
     * @return mixed|throws RequestException
     */
    abstract protected function getUrlContent($url, $data = null);
}

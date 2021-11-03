<?php

namespace Oravil\LaravelGuard;

use Illuminate\Support\Arr;
use Oravil\LaravelGuard\Providers\Provider;
use Oravil\LaravelGuard\Exceptions\ProviderDoseNotExist;

class LaravelGuard
{
    protected $provider;

    /**
     * Constructor.
     *
     * @param array $config
     *
     * @throws ProviderDoesNotExist
     */
    public function __construct(protected array $config)
    {
        $this->setDefaultProvider();
    }

    /**
     * Set the default geo provider to use.
     *
     * @throws ProviderDoesNotExist
     */
    public function setDefaultProvider()
    {
        $provider = $this->getProvider($this->getDefaultProvider());

        foreach ($this->getProviderFallbacks() as $fallback) {
            $provider->fallback($this->getProvider($fallback));
        }

        $this->setProvider($provider);
    }

    /**
     * Attempt to create the location provider.
     *
     * @param string $provider
     *
     * @return Provider
     *
     * @throws ProviderDoseNotExist
     */
    protected function getProvider($provider)
    {
        if ($this->provider === null) {
            $config = $this->config('providers.' . $this->config('provider'), []);
            // Get service class
            $class = Arr::pull($config, 'class');
        }

        if (!class_exists($class)) {
            throw ProviderDoseNotExist::forProvider($class);
        }

        return
            new $class($config);
    }

    /**
     * Get the default geo ip provider.
     *
     * @return string
     */
    protected function getDefaultProvider()
    {
        return $this->config('provider');
    }

    /**
     * Set the current provider to use.
     *
     * @param Provider $provider
     */
    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Attempt to retrieve the location of the user.
     *
     * @param string|null $ip
     *
     * @return Oravil\LaravelGuard\Location|bool
     */
    public function get($ip = null)
    {
        if ($location = $this->provider->get($ip ?: $this->getClientIP())) {
            return $location;
        }

        return false;
    }

    /**
     * Attempt to retrieve the api response of the user.
     *
     * @param string|null $ip
     *
     * @return json
     */
    public function echoApiResponse($ip = null)
    {
        if ($response = $this->provider->apiResponse($ip ?: $this->getClientIP())) {
            return $response;
        }

        return false;
    }

    /**
     * Get the client IP address.
     *
     * @return string
     */
    protected function getClientIP()
    {
        return $this->localHostTesting()
            ? $this->getLocalHostTestingIp()
            : request()->ip();
    }

    /**
     * Determine if testing is enabled.
     *
     * @return bool
     */
    protected function localHostTesting()
    {
        return $this->config('testing.enabled', true);
    }

    /**
     * Get the testing IP address.
     *
     * @return string
     */
    protected function getLocalHostTestingIp()
    {
        return $this->config('testing.valid_ip', '102.189.209.97');
    }

    /**
     * Get the fallback geo ip providers to use.
     *
     * @return array
     */
    protected function getProviderFallbacks()
    {
        return $this->config('fallbacks', []);
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
}

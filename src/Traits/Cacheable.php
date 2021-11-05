<?php

namespace Oravil\LaravelGuard\Traits;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\Fluent;
use Oravil\LaravelGuard\Support\Location;

trait Cacheable
{
    /**
     * Cache instance
     *
     * @var CacheManager
     */
    protected static $cache = null;

    /**
     * Global lifetime of the cache.
     *
     * @var int
     */
    protected $cache_expires = 30;


    /**
     * Global cache Key.
     *
     * @var string
     */
    protected $cache_tag = 'lg-location';

    /**
     * Set cache manager.
     *
     * @param CacheManager $cache
     */
    public static function setCacheInstance(CacheManager $cache)
    {
        self::$cache = $cache;
    }

    /**
     * Get cache manager.
     *
     * @return CacheManager
     */
    public static function getCacheInstance()
    {
        if (self::$cache === null) {
            self::$cache = app('cache');
        }

        return self::$cache;
    }

    /**
     * Get cache ip.
     * @param string $ip
     * @return Fluent|null
     */
    public function getCacheIp($ip)
    {
        $ip = $this->getCacheInstance()->tags($this->cache_tag)->get($ip);

        return is_array($ip) ? new Fluent($ip) : null;
    }

    /**
     * Set cache ip.
     *
     * @return bool
     */
    public function setCacheIp($ip, Location $location): bool
    {
        return $this->getCacheInstance()->tags($this->cache_tag)
            ->put(
                $ip,
                $location->toArray(),
                $this->cache_expires
            );
    }

    /**
     * Flush the cache for the given repository.
     *
     * @return bool
     */
    public function flushCache()
    {
        return $this->getCacheInstance()->tags($this->cache_tag)->flush();
    }
}

<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Http;
use Oravil\LaravelGuard\Support\Location;
use Oravil\LaravelGuard\Exceptions\RequestException;

class IpInfo extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {
        $url = $this->config('api_url');
        $content = Http::accept('application/json')->timeout(2)->get($url . $ip, [
            'token' => $this->config('api_key')
        ]);
        $json = $content->json();
        if ($content->failed()) {
            throw RequestException::forFailedRequest($url, $content->status(), $json['code'], $json['message']);
        }
        return $content;
    }

    /**
     * {@inheritdoc}
     */
    protected function hydrate(Location $location, Fluent $data)
    {
        $location->countryName = $data['country'];
        $location->countryCode = $data['country'];
        $location->regionCode  = $data['region'];
        $location->regionName  = $data['region'];
        $location->cityName    = $data['city'];
        $location->zipCode     = $data['postal'];
        $location->timeZone    = $data['timezone'];

        if ($this->securityEnabled && isset($data['privacy'])) {
            $location->isCloudProvider  = $data['privacy']['hosting'];
            $location->isAnonymous      = $data['privacy']['proxy'] || $data['privacy']['vpn'] || $data['privacy']['tor'];
            $location->isThreat         = $data['privacy']['proxy'] || $data['privacy']['vpn'] || $data['privacy']['tor'];
        }
        return $location;
    }
}

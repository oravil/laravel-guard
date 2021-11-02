<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Oravil\LaravelGuard\Exceptions\RequestException;
use Oravil\LaravelGuard\Support\Location;

class ProxyCheck extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {
        $url = $this->config('api_url');
        $content = Http::accept('application/json')->timeout(2)->get($url . $ip, [
            'key' => $this->config('api_key'),
            'vpn' => 1,
            'asn' => 1,
            'risk' => 1,
            'port' => 1,
            'seen' => 1,
            'days' => 1,
            'tag' => 'msg',
        ]);
        $json = $content->json();
        if ($content->failed() || $json['status'] == 'denied' || $json['status'] == 'error') {
            throw RequestException::forFailedRequest($url, $content->status(), null, $json['message']);
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    protected function hydrate(Location $location, Fluent $data)
    {
        $data = $data[$this->ip];
        $location->countryName = $data['country'] ?? null;
        $location->countryCode = $data['isocode'] ?? null;
        $location->regionCode = $data['regioncode'] ?? null;
        $location->regionName = $data['region'] ?? null;
        $location->cityName = $data['city'] ?? null;
        $location->latitude = (string) $data['latitude'] ?? null;
        $location->longitude = (string) $data['longitude'] ?? null;

        if ($this->securityEnabled) {
            $location->isAnonymous = $data['proxy'];
            $location->isCloudProvider = $data['type'] == 'Hosting';
            $location->isThreat = isset($data['risk']) && $data['risk'] >= $this->config('block_score') ? true : false;
        }

        return $location;
    }
}

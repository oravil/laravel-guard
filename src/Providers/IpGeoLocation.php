<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Oravil\LaravelGuard\Exceptions\RequestException;
use Oravil\LaravelGuard\Support\Location;

class IpGeoLocation extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {
        $url = $this->config('api_url');
        $content = Http::accept('application/json')->timeout(2)->get($url, [
            'apiKey' => $this->config('api_key'),
            'ip' => $ip,
            'include' => 'security',
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
        $location->countryName = $data['country_name'];
        $location->countryCode = $data['country_code2'];
        $location->regionName = $data['state_prov'];
        $location->cityName = $data['city'];
        $location->zipCode = $data['zipcode'];
        $location->isEU = $data['is_eu'];
        $location->latitude = (string) $data['latitude'];
        $location->longitude = (string) $data['longitude'];
        $location->timeZone = $data['time_zone']['name'];
        $location->currentTime = $data['time_zone']['current_time'];

        if ($this->securityEnabled && isset($data['security'])) {
            $location->isCloudProvider = $data['security']['is_cloud_provider'];
            $location->isAnonymous = $data['security']['is_anonymous'] || $data['security']['is_proxy'] || $data['security']['is_tor'];
            $location->isThreat = $data['security']['threat_score'] >= 10;
        }

        if ($this->currencyEnabled) {
            $location->currencyName = $data['currency']['name'];
            $location->currencyCode = $data['currency']['code'];
            $location->currencySymbol = $data['currency']['symbol'];
        }

        return $location;
    }
}

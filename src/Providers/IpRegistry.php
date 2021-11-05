<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Oravil\LaravelGuard\Exceptions\RequestException;
use Oravil\LaravelGuard\Support\Location;

class IpRegistry extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {
        $url = $this->config('api_url');
        $content = Http::accept('application/json')->get($url . $ip, [
            'key' => $this->config('api_key'),
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
        $location->countryName = $data->location['country']['name'];
        $location->countryCode = $data->location['country']['code'];
        $location->regionCode = $data->location['region']['code'];
        $location->regionName = $data->location['region']['name'];
        $location->cityName = $data->location['city'];
        $location->zipCode = $data->location['postal'];
        $location->latitude = (string) $data->location['latitude'];
        $location->longitude = (string) $data->location['longitude'];
        $location->areaCode = $data->location['country']['area'];
        $location->timeZone = $data->time_zone['id'];
        $location->isEU = $data->location['in_eu'];
        $location->currentTime = $data->time_zone['current_time'];

        if ($this->securityEnabled) {
            $location->isCloudProvider = $data->security['is_cloud_provider'];
            $location->isBogon = $data->security['is_bogon'];
            $location->isAnonymous = $data->security['is_anonymous'];
            $location->isThreat = $data->security['is_threat'];
        }

        if ($this->currencyEnabled) {
            $location->currencyName = $data->currency['name'];
            $location->currencyCode = $data->currency['code'];
            $location->currencySymbol = $data->currency['symbol'];
        }
        if ($this->langEnabled) {
            $location->langName = $data->location['language']['name'];
            $location->langCode = $data->location['language']['code'];
            $location->langNative = $data->location['language']['native'];
        }

        return $location;
    }
}

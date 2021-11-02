<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Oravil\LaravelGuard\Exceptions\RequestException;
use Oravil\LaravelGuard\Support\Location;

class IpData extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {
        $url = $this->config('api_url');
        $content = Http::accept('application/json')->timeout(2)->get($url . $ip, [
            'api-key' => $this->config('api_key'),
        ]);
        $json = $content->json();
        if ($content->failed()) {
            throw RequestException::forFailedRequest($url, $content->status(), null, $json['message']);
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    protected function hydrate(Location $location, Fluent $data)
    {
        $location->countryName = $data['country_name'];
        $location->countryCode = $data['country_code'];
        $location->regionCode = $data['region_code'];
        $location->regionName = $data['region'];
        $location->cityName = $data['city'];
        $location->zipCode = $data['postal'];
        $location->latitude = (string) $data['latitude'];
        $location->longitude = (string) $data['longitude'];
        $location->timeZone = $data['time_zone']['name'];
        $location->currentTime = $data['time_zone']['current_time'];

        if ($this->securityEnabled) {
            $location->isBogon = $data['threat']['is_bogon'];
            $location->isAnonymous = $data['threat']['is_anonymous'];
            $location->isThreat = $data['threat']['is_threat'];
        }

        if ($this->currencyEnabled) {
            $location->currencyName = $data['currency']['name'];
            $location->currencyCode = $data['currency']['code'];
            $location->currencySymbol = $data['currency']['symbol'];
        }
        if ($this->langEnabled) {
            $location->langName = $data['language'][0]['name'];
            $location->langCode = $data['language'][0]['code'];
            $location->langNative = $data['language'][0]['native'];
        }

        return $location;
    }
}

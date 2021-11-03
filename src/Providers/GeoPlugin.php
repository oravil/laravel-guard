<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Oravil\LaravelGuard\Exceptions\RequestException;
use Oravil\LaravelGuard\Support\Location;

class GeoPlugin extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {
        $url = $this->config('api_url');
        $content = Http::accept('application/json')->timeout(2)->get($url . $ip);
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
        $location->countryName = $data['geoplugin_countryName'];
        $location->countryCode = $data['geoplugin_countryCode'];
        $location->regionCode = $data['geoplugin_regionCode'];
        $location->regionName = $data['geoplugin_region'];
        $location->cityName = $data['geoplugin_city'];
        $location->latitude = (string) $data['geoplugin_latitude'];
        $location->longitude = (string) $data['geoplugin_longitude'];
        $location->areaCode = $data['geoplugin_areaCode'];
        $location->timeZone = $data['geoplugin_timezone'];

        if ($this->currencyEnabled) {
            $location->currencyName = $data['geoplugin_currencyCode'];
            $location->currencyCode = $data['geoplugin_currencyCode'];
            $location->currencySymbol = $data['geoplugin_currencySymbol'];
        }

        return $location;
    }
}

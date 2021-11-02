<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Oravil\LaravelGuard\Exceptions\RequestException;
use Oravil\LaravelGuard\Support\Location;

class IpApiCom extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {
        $url = $this->config('api_url');
        $content = Http::accept('application/json')->timeout(2)->get($url . $ip, [
            'access_key' => $this->config('api_key'),
            'security' => $this->config('security_plan_enable') ? 1 : 0,
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
        $location->countryCode = $data['country_code'];
        $location->regionCode = $data['region_code'];
        $location->regionName = $data['region_name'];
        $location->cityName = $data['city'];
        $location->zipCode = $data['zip'];
        $location->latitude = (string) $data['latitude'];
        $location->longitude = (string) $data['longitude'];

        if ($this->securityEnabled && $this->config('security_plan_enable')) {
            $location->isAnonymous = $data->security['is_proxy'] || $data->security['is_tor'];
            $location->isThreat = $data->security['threat_level'] === 'medium' || $data->security['threat_level'] == 'high';
        }

        if ($this->currencyEnabled && $this->config('currency_plan_enable')) {
            $location->currencyName = $data->currency['name'];
            $location->currencyCode = $data->currency['code'];
            $location->currencySymbol = $data->currency['symbol'];
        }
        if ($this->langEnabled) {
            $location->langName = $data['location']['language'][0]['name'];
            $location->langCode = $data['location']['language'][0]['code'];
            $location->langNative = $data['location']['language'][0]['native'];
        }

        return $location;
    }
}

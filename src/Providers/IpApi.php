<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Http;
use Oravil\LaravelGuard\Support\Location;
use Oravil\LaravelGuard\Exceptions\RequestException;

class IpApi extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {

        if ($this->config('api_key')) {
            $url = $this->config('pro_api_url');
            $content = Http::accept('application/json')
                ->withHeaders([
                    'User-Agent' => 'LaravelGuard'
                ])
                ->timeout(2)->get($url . $ip, [
                    'fields' => 25356799,
                    'key' => $this->config('api_key')
                ]);
        } else {
            $url = $this->config('api_url');
            $content = Http::accept('application/json')
                ->withHeaders([
                    'User-Agent' => 'LaravelGuard'
                ])
                ->timeout(2)->get($url . $ip, [
                    'fields' => 25356799
                ]);
        }
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
        $location->countryName = $data->country;
        $location->countryCode = $data->countryCode;
        $location->regionCode = $data->region;
        $location->regionName = $data->regionName;
        $location->cityName = $data->city;
        $location->zipCode = $data->zip;
        $location->latitude = (string) $data->lat;
        $location->longitude = (string) $data->lon;
        $location->timeZone = $data->timezone;

        if ($this->securityEnabled) {
            if (empty($data->as)) {
                $location->isThreat = true;
                $location->isBogon = true;
            }
            $location->isCloudProvider = $data->hosting;
            $location->isAnonymous = $data->proxy;
            if ($data->hosting || $data->proxy || empty($data->as)) {
                $location->isThreat = true;
            }
        }

        if ($this->currencyEnabled) {
            $location->currencyName = $data->currency;
            $location->currencyCode = $data->currency;
            $location->currencySymbol = $data->currency;
        }
        return $location;
    }
}

<?php

namespace Oravil\LaravelGuard\Providers;

use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Http;
use Oravil\LaravelGuard\Support\Location;
use Oravil\LaravelGuard\Exceptions\RequestException;

class IpHub extends Provider
{
    /**
     * {@inheritdoc}
     */
    protected function getUrlContent($ip, $data = null)
    {
        $url = $this->config('api_url');
        $content = Http::accept('application/json')
            ->withHeaders([
                'X-Key' => $this->config('api_key')
            ])
            ->timeout(2)
            ->get($url . $ip);
        $json = $content->json();
        if ($content->failed()) {
            throw RequestException::forFailedRequest($url, $content->status(), null, $json['error']);
        }
        return $content;
    }

    /**
     * {@inheritdoc}
     */
    protected function hydrate(Location $location, Fluent $data)
    {
        $location->countryName = $data->countryName;
        $location->countryCode = $data->countryCode;

        if ($this->securityEnabled) {
            $location->isThreat = $data->block == 1 ? true : false;
        }

        if ($data->asn === 0) {
            $location->countryName = null;
            $location->countryCode = null;

            if ($this->securityEnabled) {
                $location->isThreat = true;
                $location->isBogon = true;
            }
        }
        return $location;
    }
}

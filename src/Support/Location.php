<?php

namespace Oravil\LaravelGuard\Support;

use Illuminate\Contracts\Support\Arrayable;

class Location implements Arrayable
{
    /**
     * The IP address used to retrieve the location.
     *
     * @var string
     */
    public $ip;

    /**
     * The country name.
     *
     * @var string|null
     */
    public $countryName;

    /**
     * The country code.
     *
     * @var string|null
     */
    public $countryCode;

    /**
     * The region code.
     *
     * @var string|null
     */
    public $regionCode;

    /**
     * The region name.
     *
     * @var string|null
     */
    public $regionName;

    /**
     * The city name.
     *
     * @var string|null
     */
    public $cityName;

    /**
     * The zip code.
     *
     * @var string|null
     */
    public $zipCode;

    /**
     * The latitude.
     *
     * @var string|null
     */
    public $latitude;

    /**
     * The longitude.
     *
     * @var string|null
     */
    public $longitude;


    /**
     * The area code.
     *
     * @var string|null
     */
    public $areaCode;

    /**
     * The Is the country belong to European Union?
     *
     * @var string|null
     */
    public $isEU;

    /**
     * The currency status.
     *
     * @var bool|null
     */
    public $currencyStatus;

    /**
     * The currency name.
     *
     * @var string|null
     */
    public $currencyName;

    /**
     * The currency code.
     *
     * @var string|null
     */
    public $currencyCode;

    /**
     * The currency symbol.
     *
     * @var string|null
     */
    public $currencySymbol;

    /**
     * The lang status.
     *
     * @var bool|null
     */
    public $langStatus;

    /**
     * The lang name.
     *
     * @var string|null
     */
    public $langName;

    /**
     * The lang native.
     *
     * @var string|null
     */
    public $langNative;

    /**
     * The lang code.
     *
     * @var string|null
     */
    public $langCode;

    /**
     * The timeZone.
     *
     * @var string|null
     */
    public $timeZone;

    /**
     * The current time.
     *
     * @var string|null
     */
    public $currentTime;

    /**
     * The security status.
     *
     * @var bool|null
     */
    public $securityStatus;

    /**
     * The security Filter is_cloud_provider.
     *
     * @var bool|null
     */
    public $isCloudProvider;

    /**
     * The security Filter is_threat.
     *
     * @var bool|null
     */
    public $isThreat;

    /**
     * The security Filter is_anonymous.
     *
     * @var bool|null
     */
    public $isAnonymous;

    /**
     * The security Filter is_bogon.
     *
     * @var bool|null
     */
    public $isBogon;

    /**
     * The provider used for retrieving the location.
     *
     * @var string|null
     */
    public $provider;

    /**
     * The provider used for retrieving the location.
     *
     * @var string|null
     */
    public $provider_class;

    /**
     * Determine if the position is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        $data = $this->toArray();

        unset($data['ip']);
        unset($data['provider']);
        unset($data['provider_class']);

        return empty(array_filter($data));
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}

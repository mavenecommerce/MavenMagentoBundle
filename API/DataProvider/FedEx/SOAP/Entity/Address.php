<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

/**
 * Class Address
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
class Address
{
    use ConverterTrait;

    /**
     * @var string
     */
    protected $StreetLines;

    /**
     * @var string
     */
    protected $City;

    /**
     * @var string
     */
    protected $StateOrProvinceCode;

    /**
     * @var string
     */
    protected $PostalCode;

    /**
     * @var string
     */
    protected $CountryCode;

    /**
     * @var bool
     */
    protected $Residential = false;

    /**
     * @return string
     */
    public function getStreetLines()
    {
        return $this->StreetLines;
    }

    /**
     * @param mixed $streetLines
     *
     * @return $this
     */
    public function setStreetLines($streetLines)
    {
        $this->StreetLines = $streetLines;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->City = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getStateOrProvinceCode()
    {
        return $this->StateOrProvinceCode;
    }

    /**
     * @param string $stateOrProvinceCode
     *
     * @return $this
     */
    public function setStateOrProvinceCode($stateOrProvinceCode)
    {
        $this->StateOrProvinceCode = $stateOrProvinceCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    /**
     * @param string $postalCode
     *
     * @return $this
     */
    public function setPostalCode($postalCode)
    {
        $this->PostalCode = $postalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->CountryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->CountryCode = $countryCode;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isResidential()
    {
        return $this->Residential;
    }

    /**
     * @param boolean $residential
     *
     * @return $this
     */
    public function setResidential($residential)
    {
        $this->Residential = $residential;

        return $this;
    }
}

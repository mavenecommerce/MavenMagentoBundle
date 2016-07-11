<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

/**
 * Class Shipper
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
class Party
{
    use ConverterTrait;

    /**
     * @var Contact
     */
    protected $Contact;

    /**
     * @var Address
     */
    protected $Address;

    public function __construct()
    {
        $this->Address = new Address();
        $this->Contact = new Contact();
    }

    /**
     * @param string $personalName
     * @param string $companyName
     * @param string $phoneNumber
     */
    public function setContact($personalName, $companyName, $phoneNumber)
    {
        $this->Contact->setPersonName($personalName);
        $this->Contact->setCompanyName($companyName);
        $this->Contact->setPhoneNumber($phoneNumber);
    }

    /**
     * @param string $city
     * @param string $street
     * @param string $stateCode
     * @param string $postalCode
     * @param string $countyCode
     */
    public function setAddress($city, $street, $stateCode, $postalCode, $countyCode)
    {
        $this->Address->setCity($city);
        $this->Address->setStreetLines($street);
        $this->Address->setStateOrProvinceCode($stateCode);
        $this->Address->setPostalCode($postalCode);
        $this->Address->setCountryCode($countyCode);
    }
}

<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

/**
 * Class Contact
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
class Contact
{
    use ConverterTrait;

    /**
     * @var string
     */
    protected $PersonName;

    /**
     * @var string
     */
    protected $CompanyName;

    /**
     * @var.string
     */
    protected $PhoneNumber;

    /**
     * @return string
     */
    public function getPersonName()
    {
        return $this->PersonName;
    }

    /**
     * @param string $personName
     *
     * @return $this
     */
    public function setPersonName($personName)
    {
        $this->PersonName = $personName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->CompanyName;
    }

    /**
     * @param string $companyName
     *
     * @return $this
     */
    public function setCompanyName($companyName)
    {
        $this->CompanyName = $companyName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->PhoneNumber = $phoneNumber;

        return $this;
    }
}

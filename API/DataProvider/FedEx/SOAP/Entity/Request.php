<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

/**
 * Class Request
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
class Request
{
    use ConverterTrait;
    
    /**
     * @var array
     */
    protected $WebAuthenticationDetail;

    /**
     * @var array
     */
    protected $ClientDetail;

    /**
     * @var array
     */
    protected $Version;

    /**.
     * @var array
     */
    protected $RequestedShipment;

    /**
     * Request constructor.
     *
     * @param WebAuthUserCredentials $webAuthUserCredentials
     * @param string                 $accountNumber
     * @param string                 $meter
     */
    public function __construct(
        WebAuthUserCredentials $webAuthUserCredentials = null,
        $accountNumber = '',
        $meter = ''
    ) {
        $this->setWebAuthenticationDetail($webAuthUserCredentials);
        $this->setClientDetail($accountNumber, $meter);
    }

    /**
     * @param WebAuthUserCredentials $webAuthUserCredentials
     *
     * @return $this
     */
    public function setWebAuthenticationDetail(WebAuthUserCredentials $webAuthUserCredentials = null)
    {
        if ($webAuthUserCredentials) {
            $this->WebAuthenticationDetail = $webAuthUserCredentials->getUserCredentials();
        }

        return $this;
    }

    /**
     * @param string $accountNumber
     * @param string $meter
     *
     * @return $this
     */
    public function setClientDetail($accountNumber = '', $meter = '')
    {
        $this->ClientDetail = [
            'AccountNumber' => $accountNumber,
            'MeterNumber'   => $meter
        ];

        return $this;
    }

    /**
     * @param string $serviceId
     * @param null   $major
     * @param null   $intermediate
     * @param null   $minor
     *
     * @return $this
     */
    public function setVersion($serviceId = '', $major = null, $intermediate = null, $minor = null)
    {
        $this->Version = [
            'ServiceId' => $serviceId,
            'Major' => $major,
            'Intermediate' => $intermediate,
            'Minor' => $minor
        ];

        return $this;
    }

    /**
     * @param RequestedShipment $requestedShipment
     */
    public function setRequestedShipment(RequestedShipment $requestedShipment)
    {
        $this->RequestedShipment = $requestedShipment->toArray();
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return ($this->RequestedShipment && $this->WebAuthenticationDetail);
    }
}

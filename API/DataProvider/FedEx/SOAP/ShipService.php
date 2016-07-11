<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP;

use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\RequestedShipment;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\WebAuthUserCredentials;

/**
 * Class ShipService
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP
 */
class ShipService extends AbstractFedex
{
    const SERVICE_ID = 'ship';

    const MAJOR = 17;

    const INTERMEDIATE = 0;

    const MINOR = 0;

    /**
     * ShipService constructor.
     *
     * @param string   $key
     * @param string $password
     * @param int    $account
     * @param int    $meter
     * @param bool   $beta
     */
    public function __construct($key, $password, $account, $meter, $beta)
    {
        parent::__construct($beta);
        $this->setBaseRequestDetails($key, $password, $account, $meter);
    }

    /**
     * @param RequestedShipment $requestedShipment
     */
    public function setRequestedShipment(RequestedShipment $requestedShipment)
    {
        $this->request->setRequestedShipment($requestedShipment);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function processShipment()
    {
        if ($this->request->isValid()) {
            return $this->soapClient->processShipment($this->request->toArray());
        }

        throw new Exception('RequestedShipment or WebAuthenticationDetail is not valid!');
    }

    /**
     * @param string $key
     * @param string $password
     * @param int $accountNumber
     * @param int $meter
     */
    protected function setBaseRequestDetails($key, $password, $accountNumber, $meter)
    {
        $this->request->setVersion(self::SERVICE_ID, self::MAJOR, self::INTERMEDIATE, self::MINOR);
        $this->request->setClientDetail($accountNumber, $meter);
        $this->request->setWebAuthenticationDetail(new WebAuthUserCredentials($key, $password));
    }
}

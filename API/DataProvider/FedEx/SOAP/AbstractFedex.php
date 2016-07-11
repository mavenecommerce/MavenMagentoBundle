<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP;

use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Request;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\SoapClient;

/**
 * Class AbstractFedex
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP
 */
abstract class AbstractFedex implements FedexServiceInterface
{
    /**
     * @var \SoapClient
     */
    protected $soapClient;

    /**
     * @var Request
     */
    protected $request;

    /**
     * AbstractFedex constructor.
     *
     * @param bool $beta
     */
    public function __construct($beta)
    {
        $this->soapClient = (new SoapClient($beta))->getClient();
        $this->request = new Request();
    }
}

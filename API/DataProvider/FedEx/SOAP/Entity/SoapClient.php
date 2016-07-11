<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

/**
 * Class SoapClient
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
class SoapClient
{
    /**
     * Url to production API server.
     */
    const PROD_URL = 'https://ws.fedex.com:443/web-services';

    /**
     * @var \SoapClient
     */
    protected $soapClient;

    /**
     * @var string
     */
    protected $wsdlFile;

    /**
     * @var bool
     */
    protected static $trace = true;

    /**
     * SoapClient constructor.
     *
     * @param bool   $beta
     * @param string $wsdlFile
     */
    public function __construct($beta, $wsdlFile = '')
    {
        $this->wsdlFile = $wsdlFile;
        $this->setClient($wsdlFile);
        if (!$beta) {
            $this->setProdLocation();
        }
    }

    /**
     * @param string $wsdlFile
     *
     * @return $this
     */
    public function setClient($wsdlFile = '')
    {
        if (empty($wsdlFile)) {
            $wsdlFile = "../wsdl/ShipService_v17.wsdl";
        }
        
        $wsdlFile = dirname(__FILE__).DIRECTORY_SEPARATOR.$wsdlFile;

        $this->soapClient = new \SoapClient($wsdlFile, ['trace' => self::$trace ]);

        return $this;
    }

    /**
     * @return \SoapClient
     */
    public function getClient()
    {
        if (!$this->soapClient) {
            $this->setClient($this->wsdlFile);
        }

        return $this->soapClient;
    }

    /**
     * @return $this
     */
    public function setProdLocation()
    {
        $this->getClient()->__setLocation(self::PROD_URL);

        return $this;
    }
}

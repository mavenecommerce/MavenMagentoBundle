<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP;

/**
 * Interface FedexServiceInterface
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP
 */
interface FedexServiceInterface
{
    /**
     * @return mixed
     * @throws Exception
     */
    public function processShipment();
}

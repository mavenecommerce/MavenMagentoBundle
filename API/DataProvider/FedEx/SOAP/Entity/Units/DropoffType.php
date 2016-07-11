<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units;

/**
 * Class DropoffType
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units
 */
class DropoffType
{
    const REGULAR_PICKUP = 'REGULAR_PICKUP';
    const REQUEST_COURIER = 'REQUEST_COURIER';
    const DROP_BOX = 'DROP_BOX';
    const BUSINESS_SERVICE_CENTER = 'BUSINESS_SERVICE_CENTER';
    const STATION = 'STATION';
}

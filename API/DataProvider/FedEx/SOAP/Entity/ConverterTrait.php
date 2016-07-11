<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

/**
 * trait ConverterTrait
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
trait ConverterTrait
{
    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}

<?php

namespace Maven\Bundle\MagentoBundle\API;

use Maven\Bundle\MagentoBundle\Entity\Shipping;

/**
 * Interface ShippingProviderInterface
 *
 * @package Maven\Bundle\MagentoBundle\API
 */
interface ShippingProviderInterface
{
    /**
     * Set customer order from magento.
     *
     * @param Shipping $oroShipment
     *
     * @return mixed
     */
    public function setOroShipment(Shipping $oroShipment);

    /**
     * Return name of provider.
     *
     * @return string
     */
    public function getName();

    /**
     * Checked configuration for API.
     */
    public function checkConfig();

    /**
     * Send shipment to delivered service.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendShipment();
}

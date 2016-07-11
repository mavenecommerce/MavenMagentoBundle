<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\UPS;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;

use Maven\Bundle\MagentoBundle\API\AbstractAPI;
use Maven\Bundle\MagentoBundle\Entity\Shipping;
use Maven\Bundle\MagentoBundle\API\ShippingProviderInterface;

/**
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\UPS
 */
class UPSAPI implements ShippingProviderInterface
{
    const NAME = 'UPS';

    /**
     * @param ConfigManager $manager
     */
    public function __construct(ConfigManager $manager)
    {
    }

    /**
     * Set customer order from magento.
     *
     * @param Shipping $oroShipment
     *
     * @return mixed
     */
    public function setOroShipment(Shipping $oroShipment)
    {
        // TODO: Implement setOroShipment() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * Checked configuration for API.
     */
    public function checkConfig()
    {
        // TODO: Implement checkConfig() method.
    }

    /**
     * Send shipment to delivered service.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendShipment()
    {
        // TODO: Implement sendShipment() method.
    }
}

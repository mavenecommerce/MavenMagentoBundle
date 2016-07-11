<?php

namespace Maven\Bundle\MagentoBundle\Handler;

use OroCRM\Bundle\MagentoBundle\Provider\Transport\MagentoTransportInterface;

use Maven\Bundle\MagentoBundle\Entity\Shipping;
use Maven\Bundle\MagentoBundle\Entity\Manager\ShippingManager;

/**
 * @package Maven\Bundle\MagentoBundle\Handler
 */
class ShippingHandler
{
    use MessageTrait;

    /**
     * @var SoapTransport
     */
    protected $transport;

    /**
     * @var ShippingManager
     */
    protected $entityManager;

    /**
     * @param MagentoTransportInterface $transport
     */
    public function setTransport(MagentoTransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param ShippingManager $entityManager
     */
    public function setEntityManager(ShippingManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Shipping $shipping
     */
    public function handle(Shipping $shipping)
    {
        $transportEntity = $shipping->getOrder()
            ->getChannel()
            ->getTransport();

        $this->transport->init($transportEntity);

        try {
            $this->transport->sendShippingTrack($shipping);
            $shipping->setIsSync(true);
            $this->entityManager->update();
            $this->setSuccess($shipping->getId(), 'maven_magento.shipping.sync.synchronized');
        } catch (\Exception $e) {
            $this->setError($e->getMessage(), 'maven_magento.errors.custom');
        }
    }
}

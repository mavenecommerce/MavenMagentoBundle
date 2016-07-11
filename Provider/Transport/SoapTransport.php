<?php

namespace Maven\Bundle\MagentoBundle\Provider\Transport;

use OroCRM\Bundle\MagentoBundle\Provider\Transport\SoapTransport as BaseSoapTransport;

use Maven\Bundle\MagentoBundle\Entity\Shipping;

/**
 * Class SoapTransport
 *
 * @package Maven\Bundle\MagentoBundle\Provider\Transport
 */
class SoapTransport extends BaseSoapTransport
{
    const SHIPMENT_NOT_EXISTS = 100;
    const STOP_NUMBER = 3;

    /**
     * @param Shipping $shipping
     *
     * @return Shipping
     * @throws \Exception
     */
    public function sendShippingTrack(Shipping &$shipping)
    {
        if ($shipping->getMagentoShipmentId() == null) {
            $shipping->setMagentoShipmentId($this->createShipment($shipping));
        }
        try {
            $this->client->salesOrderShipmentAddTrack(
                $this->sessionId,
                $shipping->getMagentoShipmentId(),
                $shipping->getCarrier(),
                $shipping->getCarrier(),
                $shipping->getTrackingNumber()
            );
        } catch (\Exception $e) {
            if ($e->faultcode == self::SHIPMENT_NOT_EXISTS) {
                throw $e;
            }
        }

        return $shipping;
    }

    /**
     * @param Shipping $shipping
     *
     * @return int
     * @throws \Exception
     */
    public function createShipment(Shipping $shipping)
    {
        $options = [];

        foreach ($shipping->getQtyitems() as $item) {
            array_push($options, [
                'order_item_id' => $item->getOrderItem()->getOriginId(),
                'qty'           => $item->getQty()
            ]);
        }

        try {
            $response = $this->client->salesOrderShipmentCreate(
                $this->sessionId,
                $shipping->getOrder()
                    ->getIncrementId(),
                $options
            );
        } catch (\Exception $e) {
            throw $e;
        }

        return $response;
    }
}

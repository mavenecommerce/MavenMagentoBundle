<?php

namespace Maven\Bundle\MagentoBundle\Datagrid\Extension\MassAction;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

use OroCRM\Bundle\MagentoBundle\Entity\OrderItem;

use Oro\Bundle\SecurityBundle\ORM\Walker\AclHelper;
use Oro\Bundle\TranslationBundle\Translation\Translator;

use Maven\Bundle\MagentoBundle\Entity\QtyItem;
use Maven\Bundle\MagentoBundle\Entity\ShipmentItem;
use Maven\Bundle\MagentoBundle\Entity\Shipping;

/**
 * Class CreateShipmentActionHandler
 *
 * @package Maven\Bundle\MagentoBundle\Datagrid\Extension\MassAction
 */
class CreateShipmentActionHandler
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @var AclHelper
     */
    protected $aclHelper;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * CreateShipmentActionHandler constructor.
     *
     * @param EntityManager $manager
     * @param AclHelper     $aclHelper
     * @param Translator    $translator
     */
    public function __construct(EntityManager $manager, AclHelper $aclHelper, Translator $translator)
    {
        $this->manager = $manager;
        $this->aclHelper = $aclHelper;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function handle(Request $request)
    {
        $params = $this->parseParams($request);
        $shipping = new Shipping();
        $shipping->setIsSync(false);
        $shipping->setSent(false);
        $orderItems = $this->fetchOrderItems($params);
        if (empty($orderItems)) {
            throw new \Exception("Haven't any items in order!");
        }

        $shipping->setOrder(current($orderItems)->getOrder());

        foreach ($orderItems as $item) {
            $qty = new QtyItem();
            $this->setQty($qty, $item, $params);
            $qty->setOrderItem($item);
            $shipping->addQtyitem($qty);
            $this->manager->persist($qty);
        }

        $this->manager->persist($shipping);
        $this->manager->flush();

        return [
            'successful' => true,
            'message' => $this->translator->trans('maven_magento.shipping.created')
        ];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    private function parseParams(Request $request)
    {
        return [
            'inset' => (bool) $request->get('inset'),
            'ids'   => $request->get('values') ? explode(',', $request->get('values')) : '',
            'orderId' => $request->get('orderId'),
            'qty' => $request->get('qty')
        ];
    }

    /**
     * @param array $params
     *
     * @return OrderItem[]
     */
    private function fetchOrderItems(array $params)
    {
        if (!$params['inset']) {
            return $this->manager->getRepository(OrderItem::class)->findBy(['order' => $params['orderId']]);
        }

        return $this->manager->getRepository(OrderItem::class)->findById($params['ids']);
    }

    /**
     * @param QtyItem   $qtyItem
     * @param OrderItem $orderItem
     * @param array     $params
     */
    private function setQty(QtyItem &$qtyItem, OrderItem $orderItem, array $params)
    {
        $requestQty = $params['qty'];
        $qty = $orderItem->getQty();
        if ($requestQty && array_key_exists($orderItem->getId(), $requestQty)) {
            $qty = $requestQty[$orderItem->getId()];
        }

        $qtyItem->setQty($qty);
    }
}

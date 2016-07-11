<?php

namespace Maven\Bundle\MagentoBundle\Entity\Manager;

use Doctrine\Common\Persistence\ObjectManager;

use Maven\Bundle\MagentoBundle\Entity\Shipping;

/**
 * @package Maven\Bundle\MagentoBundle\Entity\Manager
 */
class ShippingManager
{
    /**
     * @var string
     */
    protected $class;
    /**
     * @var EntityRepository
     */
    protected $repository;
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    /**
     * @param ObjectManager $objectManager
     * @param string $class
     */
    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
    }
    /**
     * @return BaseMenuRepository
     */
    public function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = $this->objectManager->getRepository($this->class);
        }
        return $this->repository;
    }

    /**
     * @param Shipping $shipping
     */
    public function save(Shipping $shipping)
    {
        $this->objectManager->persist($shipping);
        $this->objectManager->flush();
    }

    /**
     * Update entity.
     */
    public function update()
    {
        $this->objectManager->flush();
    }
}

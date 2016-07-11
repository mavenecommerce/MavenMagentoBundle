<?php

namespace Maven\Bundle\MagentoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use OroCRM\Bundle\MagentoBundle\Entity\OrderItem;

/**
 * QtyItem
 */
class QtyItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $qty;

    /**
     * @var OrderItem
     */
    private $orderItem;

    /**
     * @var Collection
     */
    private $shippings;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shippings = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return $this
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set orderItem
     *
     * @param OrderItem $orderItem
     *
     * @return $this
     */
    public function setOrderItem(OrderItem $orderItem = null)
    {
        $this->orderItem = $orderItem;

        return $this;
    }

    /**
     * Get orderItem
     *
     * @return OrderItem
     */
    public function getOrderItem()
    {
        return $this->orderItem;
    }

    /**
     * Add shipping
     *
     * @param OrderItem $shipping
     *
     * @return $this
     */
    public function addShipping(OrderItem $shipping)
    {
        if (!$this->shippings->contains($shipping)) {
            $this->shippings[] = $shipping;
        }

        return $this;
    }

    /**
     * Remove shipping
     *
     * @param OrderItem $shipping
     */
    public function removeShipping(OrderItem $shipping)
    {
        if ($this->shippings->contains($shipping)) {
            $this->shippings->removeElement($shipping);
        }
    }

    /**
     * Get shippings
     *
     * @return Collection
     */
    public function getShippings()
    {
        return $this->shippings;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this);
    }
}

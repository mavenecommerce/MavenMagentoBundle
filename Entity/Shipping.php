<?php

namespace Maven\Bundle\MagentoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use OroCRM\Bundle\MagentoBundle\Entity\Order;

/**
 * Shipping
 */
class Shipping
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $magentoShipmentId;

    /**
     * @var string
     */
    private $carrier;

    /**
     * @var string
     */
    private $trackingNumber;

    /**
     * @var boolean
     */
    private $isSync;

    /**
     * @var boolean
     */
    private $sent;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var Collection
     */
    private $qtyitems;

    /**
     * @var Document
     */
    private $document;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->qtyitems = new ArrayCollection();
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
     * Get magentoShipmentId
     *
     * @return integer
     */
    public function getMagentoShipmentId()
    {
        return $this->magentoShipmentId;
    }

    /**
     * Set magentoShipmentId
     *
     * @param integer $magentoShipmentId
     *
     * @return $this
     */
    public function setMagentoShipmentId($magentoShipmentId)
    {
        $this->magentoShipmentId = $magentoShipmentId;

        return $this;
    }

    /**
     * Get carrier
     *
     * @return string
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * Set carrier
     *
     * @param string $carrier
     *
     * @return $this
     */
    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;

        return $this;
    }

    /**
     * Get trackingNumber
     *
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    /**
     * Set trackingNumber
     *
     * @param string $trackingNumber
     *
     * @return $this
     */
    public function setTrackingNumber($trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    /**
     * Get isSync
     *
     * @return boolean
     */
    public function getIsSync()
    {
        return $this->isSync;
    }

    /**
     * Set isSync
     *
     * @param boolean $isSync
     *
     * @return $this
     */
    public function setIsSync($isSync)
    {
        $this->isSync = $isSync;

        return $this;
    }

    /**
     * Get sent
     *
     * @return boolean
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set sent
     *
     * @param boolean $sent
     *
     * @return $this
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get order
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order
     *
     * @param Order $order
     *
     * @return $this
     */
    public function setOrder(Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Add qtyitem
     *
     * @param QtyItem $qtyitem
     *
     * @return $this
     */
    public function addQtyitem(QtyItem $qtyitem)
    {
        if (!$this->qtyitems->contains($qtyitem)) {
            $this->qtyitems[] = $qtyitem;
        }

        return $this;
    }

    /**
     * Remove qtyitem
     *
     * @param QtyItem $qtyitem
     */
    public function removeQtyitem(QtyItem $qtyitem)
    {
        if ($this->qtyitems->contains($qtyitem)) {
            $this->qtyitems->removeElement($qtyitem);
        }
    }

    /**
     * Get qtyitems
     *
     * @return Collection
     */
    public function getQtyitems()
    {
        return $this->qtyitems;
    }

    /**
     * @return $this
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    /**
     * @return $this
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }
    
    /**
     * Get document
     *
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set document
     *
     * @param Document $document
     *
     * @return $this
     */
    public function setDocument(Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this);
    }
}

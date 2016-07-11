<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units\Dimensions;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units\Weight;

/**
 * Class PackageLineItem
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
class PackageLineItem
{
    use ConverterTrait;

    /**
     * @var int
     */
    protected $SequenceNumber;

    /**
     * @var int
     */
    protected $GroupPackageCount;

    /**.
     * @var array
     */
    protected $Weight;

    /**
     * @var array
     */
    protected $Dimensions;

    public function __construct($groupPackageCount = 1, $sequenceNumber = 1)
    {
        $this->GroupPackageCount = $groupPackageCount;
        $this->SequenceNumber = $sequenceNumber;
    }

    /**
     * @param $value
     * @param $unit
     *
     * @return $this
     */
    public function setWeight($value, $unit = '')
    {
        $this->Weight = (new Weight($value, $unit))->toArray();

        return $this;
    }

    /**
     * @param float  $length
     * @param float  $width
     * @param float  $height
     * @param string $units
     *
     * @return $this
     */
    public function setDimensions($length, $width, $height, $units)
    {
        $this->Dimensions = (new Dimensions($length, $width, $height, $units))->toArray();

        return $this;
    }

    /**
     * @param int $count
     */
    public function setGroupPackageCount($count = 1)
    {
        $this->GroupPackageCount = $count;
    }

    /**
     * @param int $number
     */
    public function setSequenceNumber($number = 1)
    {
        $this->SequenceNumber = $number;
    }
}

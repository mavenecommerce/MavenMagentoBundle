<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units;

use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\ConverterTrait;

/**
 * Class Dimensions
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units
 */
class Dimensions
{
    use ConverterTrait;

    const IN = 'IN';
    const CM = 'CM';

    /**
     * @var float
     */
    protected $Length;

    /**
     * @var float
     */
    protected $Width;

    /**
     * @var float
     */
    protected $Height;

    /**
     * @var string
     */
    protected $Units;

    /**
     * Dimensions constructor.
     *
     * @param float  $length
     * @param float  $width
     * @param float  $height
     * @param string $units
     */
    public function __construct($length, $width, $height, $units)
    {
        $this->Length = $length;
        $this->Width  = $width;
        $this->Height = $height;
        $this->Units  = $units;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->Length;
    }

    /**
     * @param float $length
     *
     * @return $this
     */
    public function setLength($length)
    {
        $this->Length = $length;

        return $this;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->Width;
    }

    /**
     * @param float $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        $this->Width = $width;

        return $this;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->Height;
    }

    /**
     * @param float $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        $this->Height = $height;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnits()
    {
        return $this->Units;
    }

    /**
     * @param string $units
     *
     * @return $this
     * @throws Exception
     */
    public function setUnits($units)
    {
        if (empty($units)) {
            $units = self::IN;
        }

        if (!$this->isValid($units)) {
            throw new Exception('Use only allowed units: CM or IN');
        }

        $this->Units = $units;

        return $this;
    }

    /**
     * @param $units
     *
     * @return bool
     */
    protected function isValid($units)
    {
        return ($units !== null && ($units === self::CM || $units ===self::IN));
    }
}

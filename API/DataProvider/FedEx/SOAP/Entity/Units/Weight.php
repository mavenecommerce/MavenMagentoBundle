<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units;

use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\ConverterTrait;

/**
 * Class Weight
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units
 */
class Weight
{
    use ConverterTrait;

    const LB = 'LB';
    const KG = 'KG';

    /**
     * @var float|null
     */
    protected $Value;

    /**
     * @var string
     */
    protected $Units;

    /**
     * Weight constructor.
     *
     * @param float  $value
     * @param string $units
     */
    public function __construct($value = null, $units = self::LB)
    {
        $this->Value = $value;
        $this->setUnits($units);
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->Value = $value;

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
     * @throws \Exception
     */
    public function setUnits($units = '')
    {
        if (empty($units)) {
            $units = self::LB;
        }

        if (!$this->isValid($units)) {
            throw new \Exception('Use only allowed units: LB or KG');
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
        return (!empty($units) && ($units === self::LB || $units ===self::KG));
    }
}

<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units\DropoffType;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units\PackagingType;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units\ServiceType;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units\Weight;

/**
 * Class RequestedShipment
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
class RequestedShipment
{
    use ConverterTrait;

    /**
     * @var string
     */
    protected $ShipTimestamp;

    /**
     * @var string
     */
    protected $DropoffType;

    /**
     * @var string
     */
    protected $ServiceType;

    /**
     * @var string
     */
    protected $PackagingType;

    /**
     * @var array
     */
    protected $TotalWeight;

    /**
     * @var Party
     */
    protected $Shipper;

    /**
     * @var Party
     */
    protected $Recipient;

    /**
     * @var int
     */
    protected $PackageCount;

    /**
     * @var array
     */
    protected $RequestedPackageLineItems;

    /**
     * @var array
     */
    protected $LabelSpecification;

    /**
     * @var array
     */
    protected $ShippingChargesPayment;

    public function __construct()
    {
        $this->ShipTimestamp = date('c');
        $this->DropoffType = DropoffType::REGULAR_PICKUP;
        $this->ServiceType = ServiceType::STANDARD_OVERNIGHT;
        $this->PackagingType = PackagingType::YOUR_PACKAGING;
        $this->Shipper = new Party();
        $this->Recipient = new Party();
        $this->PackageCount = 1;
        $this->RequestedPackageLineItems = [];
        $this->setTotalWeight(new Weight(0));
        $this->setLabelSpecification();
        $this->setShippingChargesPayment();
    }

    /**
     * @param PackageLineItem $packageLineItem
     */
    public function addRequestedPackageLineItems(PackageLineItem $packageLineItem)
    {
        $this->RequestedPackageLineItems = [];
        $this->RequestedPackageLineItems[] = $packageLineItem->toArray();
    }

    /**
     * @param Weight|float $weight
     * @param string       $unit
     *
     * @return $this
     */
    public function setTotalWeight($weight, $unit = '')
    {
        if ($weight instanceof Weight) {
            $this->TotalWeight = $weight->toArray();

            return $this;
        }

        $this->TotalWeight = new Weight($weight, $unit);

        return $this;
    }

    /**
     * @param $count
     *
     * @return $this
     */
    public function setPackageCount($count)
    {
        $this->PackageCount = $count;

        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setShipper(array $options)
    {
        $this->Shipper->setAddress(
            $options['city'],
            $options['street'],
            $options['stateCode'],
            $options['postalCode'],
            $options['countryCode']
        );

        $this->Shipper->setContact(
            $options['personalName'],
            $options['companyName'],
            $options['phoneNumber']
        );

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setRecipient(array $options)
    {
        $this->Recipient->setAddress(
            $options['city'],
            $options['street'],
            $options['stateCode'],
            $options['postalCode'],
            $options['countryCode']
        );

        $this->Recipient->setContact(
            $options['personalName'],
            $options['companyName'],
            $options['phoneNumber']
        );

        $this->setShippingChargesPayment($options['accountNumber'], $options['countryCode']);

        return $this;
    }

    /**
     * Set label.
     */
    public function setLabelSpecification(array $options = [])
    {
        if (empty($options)) {
            $this->LabelSpecification = [
                'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
                'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
                'LabelStockType' => 'PAPER_7X4.75'
            ];

            return;
        }

        $this->LabelSpecification = $options;
    }

    /**
     * @param int    $accountNumber
     * @param string $countryCode
     *
     * @return $this
     */
    public function setShippingChargesPayment($accountNumber = 0, $countryCode = '')
    {
        $this->ShippingChargesPayment = [
            'PaymentType' => 'SENDER',
            'Payor' => [
                'ResponsibleParty' => [
                    'AccountNumber' => $accountNumber,
                    'Contact' => null,
                    'Address' => [
                        'CountryCode' => $countryCode
                    ]
                ]
            ]
        ];

        return $this;
    }
}

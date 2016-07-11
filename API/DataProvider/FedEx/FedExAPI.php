<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;

use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\PackageLineItem;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\RequestedShipment;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity\Units\Weight;
use Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\ShipService;
use Maven\Bundle\MagentoBundle\Entity\Shipping;
use Maven\Bundle\MagentoBundle\API\ShippingProviderInterface;

/**
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx
 */
class FedExAPI implements ShippingProviderInterface
{
    const NAME = 'fedex';
    const LB_MAX = 150;
    const KG_MAX = 68;

    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var array
     */
    protected $connectSettings;

    /**
     * @var Shipping
     */
    protected $oroShipment;

    /**
     * @var RequestedShipment
     */
    protected $shipment;
    
    private $translator;

    /**
     * @param ConfigManager $configManager
     * @param Translator    $translator
     */
    public function __construct(ConfigManager $configManager, Translator $translator)
    {
        $this->configManager = $configManager;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function sendShipment()
    {
        $config = $this->getConnectSettings();
        $fedexShip = new ShipService(
            $config['key'],
            $config['password'],
            $config['account'],
            $config['meter'],
            $config['beta']
        );

        $requestedShipment = new RequestedShipment();
        $this->setLineItems($requestedShipment);
        $this->setRecipientAddress($requestedShipment);
        $this->setShipperAddress($requestedShipment);

        $fedexShip->setRequestedShipment($requestedShipment);

        try {
            $response = $fedexShip->processShipment();
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param RequestedShipment $requestedShipment
     *
     * At this time work only with one package which less that 150 lb (or 68 KG)
     */
    protected function setLineItems(RequestedShipment &$requestedShipment)
    {
        $totalWeight = 0;
        $packageItem = new PackageLineItem();
        $packageItem->setGroupPackageCount(1);

        foreach ($this->oroShipment->getQtyitems() as $key => $item) {
            $totalWeight += ($item->getOrderItem()
                    ->getWeight() * $item->getQty());
        }
        $this->checkTotalWeight($totalWeight);
        $packageItem->setWeight($totalWeight);
        $requestedShipment->addRequestedPackageLineItems($packageItem);
        $requestedShipment->setTotalWeight($totalWeight);
        $requestedShipment->setPackageCount(1);
    }

    /**
     * @return array
     */
    private function getConnectSettings()
    {
        if (!$this->connectSettings) {
            $this->setConnectSettings();
        }

        return $this->connectSettings;
    }

    /**
     * @return $this
     */
    private function setConnectSettings()
    {
        $this->connectSettings = [
            'key'      => $this->configManager->get('maven_magento.fedex_key'),
            'password' => $this->configManager->get('maven_magento.fedex_password'),
            'account'  => $this->configManager->get('maven_magento.fedex_account'),
            'meter'    => $this->configManager->get('maven_magento.fedex_meter'),
            'beta'     => (bool)$this->configManager->get('maven_magento.fedex_beta'),
        ];

        return $this;
    }

    /**
     * @param RequestedShipment $requestedShipment
     *
     * @return $this
     */
    private function setRecipientAddress(RequestedShipment &$requestedShipment)
    {
        $address = $this->oroShipment->getOrder()->getAddresses()->first();

        $requestedShipment->setRecipient([
            'street'       => $address->getStreet(),
            'city'         => $address->getCity(),
            'stateCode'    => !$address->getRegion() ? $address->getRegionText() : $address->getRegionCode(),
            'postalCode'   => $address->getPostalCode(),
            'countryCode'  => $address->getCountry()
                ->getIso2Code(),
            'personalName' => sprintf("%s %s", $address->getFirstName(), $address->getLastName()),
            'companyName'  => $address->getOrganization(),
            'phoneNumber'  => $address->getPhone(),
            'accountNumber' => $this->getConnectSettings()['account']
        ]);

        return $this;
    }

    /**
     * @param RequestedShipment $requestedShipment
     *
     * @return $this
     */
    private function setShipperAddress(RequestedShipment &$requestedShipment)
    {
        $requestedShipment->setShipper([
            'street'       => $this->configManager->get('maven_magento.shipper_address1'),
            'city'         => $this->configManager->get('maven_magento.shipper_city'),
            'stateCode'    => $this->configManager->get('maven_magento.shipper_state'),
            'postalCode'   => $this->configManager->get('maven_magento.shipper_zip'),
            'countryCode'  => $this->configManager->get('maven_magento.shipper_country'),
            'personalName' => $this->configManager->get('maven_magento.shipper_contact'),
            'companyName'  => $this->configManager->get('maven_magento.shipper_company'),
            'phoneNumber'  => $this->configManager->get('maven_magento.shipper_phone'),
        ]);

        return $this;
    }

    /**
     * Set customer order from magento.
     *
     * @param Shipping $oroShipment
     *
     * @return mixed
     */
    public function setOroShipment(Shipping $oroShipment)
    {
        $this->oroShipment = $oroShipment;
    }

    /**
     * Return name of provider.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @throws \Exception
     */
    public function checkConfig()
    {
        $connectSettings = $this->getConnectSettings();

        if (!$connectSettings['account'] &&
            !$connectSettings['meter'] &&
            !$connectSettings['key'] &&
            !$connectSettings['password']) {
            throw new \Exception($this->translator->trans('maven_magento.errors.provider.data'));
        }
    }

    /**
     * @param float  $weight
     * @param string $unit
     *
     * @throws \Exception
     */
    private function checkTotalWeight($weight, $unit = '')
    {
        if (empty($unit)) {
            $unit = Weight::LB;
        };

        if ($weight >= self::LB_MAX && $unit === Weight::LB || $weight >= self::KG_MAX && $unit === Weight::KG) {
            $overweight = $unit === Weight::LB ?
                ($weight - self::LB_MAX).' '.Weight::LB
                : ($weight - self::KG_MAX).' '. Weight::KG;
            throw new \Exception(
                $this->translator->trans(
                    'maven_magento.shipping.errors.overweight',
                    [
                        '%overweight%' => $overweight,
                    ]
                )
            );
        }
    }
}

<?php

namespace Maven\Bundle\MagentoBundle\Handler;

use Doctrine\ORM\EntityManager;

use Maven\Bundle\MagentoBundle\API\ShippingProviderInterface;
use Maven\Bundle\MagentoBundle\Entity\Document;
use Maven\Bundle\MagentoBundle\Entity\Shipping;

/**
 * @package Maven\Bundle\MagentoBundle\Handler
 */
class DeliveryHandler
{
    use MessageTrait;

    /**
     * @var array
     */
    protected $providers;

    /**
     * @var DocumentHandler
     */
    protected $documentHandler;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * DeliveryHandler constructor.
     */
    public function __construct()
    {
        $this->providers = [];

    }

    /**
     * @param DocumentHandler $documentHandler
     *
     * @return $this
     */
    public function setDocumentHandler(DocumentHandler $documentHandler)
    {
        $this->documentHandler = $documentHandler;

        return $this;
    }

    /**
     * @param EntityManager $entityManager
     *
     * @return $this
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->em = $entityManager;

        return $this;
    }

    /**
     * @param ShippingProviderInterface $provider
     */
    public function addProvider(ShippingProviderInterface $provider)
    {
        if (!in_array($provider, $this->providers)) {
            $this->providers[$provider->getName()] = $provider;
        }
    }

    /**
     * @param Shipping $shipping
     * @param string   $providerName
     *
     * @return string|void
     */
    public function handle(Shipping $shipping, $providerName)
    {
        $provider = $this->getProvider($providerName);

        if (! $provider || $shipping->getSent()) {
            return;
        }

        $provider->setOroShipment($shipping);

        try {
            $response = $provider->sendShipment();
            if ($response->HighestSeverity === "SUCCESS" || $response->HighestSeverity === "WARNING") {
                $details = $response->CompletedShipmentDetail->CompletedPackageDetails;
                $shipping->setCarrier($providerName);
                $shipping->setTrackingNumber($details->TrackingIds->TrackingNumber);
                $shipping->setSent(true);

                $this->createDocument(
                    $providerName,
                    $details->Label->ImageType,
                    $details->Label->Parts->Image,
                    $shipping
                );

                $this->setSuccess('', 'maven_magento.shipping.updated');
                return;
            }

            $message = $response->Notifications->Message;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $this->setError($message, 'maven_magento.errors.custom');

        return;
    }

    /**
     * @return array
     */
    public function getProvidersNames()
    {
        return array_keys($this->providers);
    }

    /**
     * @param string $providerName
     *
     * @return mixed|void
     */
    private function getProvider($providerName)
    {
        $provider = $this->providers[$providerName];

        try {
            $provider->checkConfig();
            return $provider;
        } catch (\Exception $e) {
            $this->setError($e->getMessage(), 'maven_magento.errors.custom');
            return;
        }
    }

    /**
     * @param string   $name
     * @param string   $extension
     * @param string   $content
     * @param Shipping $shipping
     */
    private function createDocument($name, $extension, $content, Shipping &$shipping)
    {
        $document = new Document();
        $document->setName($name);
        $shipping->setDocument($document);

        try {
            $filePath = $this->documentHandler->write($content, $extension);
            $document->setPath($filePath);
            $this->em->persist($document);
            $this->em->flush();
        } catch (\Exception $e) {
            $this->setError($e->getMessage(), 'maven_magento.errors.custom');
            return;
        }
    }
}

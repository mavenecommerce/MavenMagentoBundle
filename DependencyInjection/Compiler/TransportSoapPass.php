<?php

namespace Maven\Bundle\MagentoBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class TransportSoapPass
 *
 * @package Maven\Bundle\MagentoBundle\DependencyInjection\Compiler
 */
class TransportSoapPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('orocrm_magento.transport.soap_transport.class')) {
            $container->setParameter(
                'orocrm_magento.transport.soap_transport.class',
                $container->getParameter('maven_magento.transport.soap_transport.class')
            );
        }
    }
}

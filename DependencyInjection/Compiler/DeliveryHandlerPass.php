<?php

namespace Maven\Bundle\MagentoBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @package Maven\Bundle\MagentoBundle\DependencyInjection\Compiler
 */
class DeliveryHandlerPass implements CompilerPassInterface
{
    const HANDLER_SERVICE_ID = 'maven_magento.delivery_handler';
    const TAG = 'maven_magento.provider';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition(self::HANDLER_SERVICE_ID)) {
            $definition = $container->getDefinition(self::HANDLER_SERVICE_ID);

            $taggedServices = $container->findTaggedServiceIds(
                self::TAG
            );

            foreach ($taggedServices as $id => $tags) {
                $definition->addMethodCall(
                    'addProvider',
                    array(new Reference($id))
                );
            }
        }
    }
}

<?php

namespace Maven\Bundle\MagentoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;

/**
 * @package Maven\Bundle\MagentoBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Bundle configuration structure
     *
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('maven_magento');

        SettingsBuilder::append($rootNode, [
            'ups_key'    => [
                'value' => null,
                'type'  => 'text',
            ],
            'ups_user'   => [
                'value' => null,
                'type'  => 'text',
            ],
            'ups_secret' => [
                'value' => null,
                'type'  => 'text',
            ],
            'fedex_key' => ['value' => null],
            'fedex_password' => ['value' => null],
            'fedex_account'  => ['value' => null],
            'fedex_meter'  => ['value' => null],
            'fedex_beta'  => ['value' => null],
            'shipper_company' => ['value' => null],
            'shipper_contact' => ['value' => null],
            'shipper_city'    => ['value' => null],
            'shipper_state' => ['value' => null],
            'shipper_country' => ['value' => null],
            'shipper_zip' => ['value' => null],
            'shipper_phone' => ['value' => null],
            'shipper_address1' => ['value' => null],
            'shipper_email' => ['value' => null],
        ]);

        return $treeBuilder;
    }
}

<?php

namespace Maven\Bundle\MagentoBundle\Datagrid\Extension\MassAction\Actions;

use Oro\Bundle\DataGridBundle\Extension\Action\ActionConfiguration;
use Oro\Bundle\DataGridBundle\Extension\MassAction\Actions\AbstractMassAction;

/**
 * Class CreateShipmentAction
 *
 * @package Maven\Bundle\MagentoBundle\Datagrid\Extension\MassAction\Actions
 */
class CreateShipmentAction extends AbstractMassAction
{
    /** @var array */
    protected $requiredOptions = ['handler', 'entity_name', 'data_identifier'];

    /**
     * {@inheritDoc}
     */
    public function setOptions(ActionConfiguration $options)
    {
        if (empty($options['handler'])) {
            $options['handler'] = 'maven_magento.mass_action.create_shipment_handler';
        }

        if (empty($options['frontend_type'])) {
            $options['frontend_type'] = 'createshipment';
        }

        if (empty($options['route'])) {
            $options['route'] = 'maven_magento_create_shipment';
        }

        if (empty($options['frontend_handle'])) {
            $options['frontend_handle'] = 'createshipment';
        }

        $options['confirmation'] = false;

        return parent::setOptions($options);
    }
}

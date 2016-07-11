<?php

namespace Maven\Bundle\MagentoBundle\Datagrid;

use Oro\Bundle\DataGridBundle\Datasource\ResultRecordInterface;

/**
 * Class ActionPermissionProvider
 *
 * @package Maven\Bundle\MagentoBundle\Datagrid
 */
class ActionPermissionProvider
{
    /**
     * @param ResultRecordInterface $record
     *
     * @return array
     */
    public function getActionPermissions(ResultRecordInterface $record)
    {
        return [
            'activate'   => false,
            'clone'      => false,
            'deactivate' => false,
            'delete'     => false,
            'update'     => false,
            'view'       => false,
        ];
    }
}

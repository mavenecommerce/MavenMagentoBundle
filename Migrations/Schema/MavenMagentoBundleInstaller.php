<?php

namespace Maven\Bundle\MagentoBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * Class MavenMagentoBundleInstaller
 *
 * @package Maven\Bundle\MagentoBundle\Migrations\Schema
 */
class MavenMagentoBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createMavenMagentoDocumentTable($schema);
        $this->createMavenMagentoQtyitemTable($schema);
        $this->createMavenMagentoShippingTable($schema);
        $this->createMavenMagentoShippingQtyitemTable($schema);

        /** Foreign keys generation **/
        $this->addMavenMagentoQtyitemForeignKeys($schema);
        $this->addMavenMagentoShippingForeignKeys($schema);
        $this->addMavenMagentoShippingQtyitemForeignKeys($schema);
    }

    /**
     * Create maven_magento_document table
     *
     * @param Schema $schema
     */
    protected function createMavenMagentoDocumentTable(Schema $schema)
    {
        $table = $schema->createTable('maven_magento_document');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('path', 'string', ['length' => 255]);
        $table->addColumn('created_at', 'datetime', []);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Create maven_magento_qtyitem table
     *
     * @param Schema $schema
     */
    protected function createMavenMagentoQtyitemTable(Schema $schema)
    {
        $table = $schema->createTable('maven_magento_qtyitem');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('order_item_id', 'integer', ['notnull' => false]);
        $table->addColumn('qty', 'integer', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['order_item_id'], null, []);
    }

    /**
     * Create maven_magento_shipping table
     *
     * @param Schema $schema
     */
    protected function createMavenMagentoShippingTable(Schema $schema)
    {
        $table = $schema->createTable('maven_magento_shipping');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('order_id', 'integer', ['notnull' => false]);
        $table->addColumn('document_id', 'integer', ['notnull' => false]);
        $table->addColumn('magento_shipment_id', 'integer', ['notnull' => false]);
        $table->addColumn('carrier', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('tracking_number', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('is_sync', 'boolean', ['notnull' => false]);
        $table->addColumn('sent', 'boolean', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['document_id'], null);
        $table->addIndex(['order_id'], null, []);
    }

    /**
     * Create maven_magento_shipping_qtyitem table
     *
     * @param Schema $schema
     */
    protected function createMavenMagentoShippingQtyitemTable(Schema $schema)
    {
        $table = $schema->createTable('maven_magento_shipping_qtyitem');
        $table->addColumn('shipping_id', 'integer', []);
        $table->addColumn('qty_item_id', 'integer', []);
        $table->setPrimaryKey(['shipping_id', 'qty_item_id']);
        $table->addIndex(['shipping_id'], null, []);
        $table->addIndex(['qty_item_id'], null, []);
    }

    /**
     * Add maven_magento_qtyitem foreign keys.
     *
     * @param Schema $schema
     */
    protected function addMavenMagentoQtyitemForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('maven_magento_qtyitem');
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_magento_order_items'),
            ['order_item_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add maven_magento_shipping foreign keys.
     *
     * @param Schema $schema
     */
    protected function addMavenMagentoShippingForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('maven_magento_shipping');
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_magento_order'),
            ['order_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('maven_magento_document'),
            ['document_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
    }

    /**
     * Add maven_magento_shipping_qtyitem foreign keys.
     *
     * @param Schema $schema
     */
    protected function addMavenMagentoShippingQtyitemForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('maven_magento_shipping_qtyitem');
        $table->addForeignKeyConstraint(
            $schema->getTable('maven_magento_shipping'),
            ['shipping_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('maven_magento_qtyitem'),
            ['qty_item_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
    }
}

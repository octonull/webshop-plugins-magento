<?php

namespace PWS\Billingo\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table_pws_billingo_billingo = $setup->getConnection()->newTable($setup->getTable('pws_billingo_billingo'));
        
        $table_pws_billingo_billingo->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,'auto_increment' => true],
            'Entity ID'
        );

        $table_pws_billingo_billingo->addColumn(
            'id_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true],
            'id_order'
        );
        
        $table_pws_billingo_billingo->addColumn(
            'link',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'link'
        );
        
        $table_pws_billingo_billingo->addColumn(
            'invoice_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'invoice_id'
        );
        
        $table_pws_billingo_billingo->addColumn(
            'invoice_nr',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'invoice_nr'
        );
        
        $table_pws_billingo_billingo->addColumn(
            'date_add',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [],
            'date_add'
        );


        $table_pws_billingo_partnerhash = $setup->getConnection()->newTable($setup->getTable('pws_billingo_partnerhash'));
        
        $table_pws_billingo_partnerhash->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,'auto_increment' => true),
            'Entity ID'
        );

        $table_pws_billingo_partnerhash->addColumn(
            'partner_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true],
            'partner_id'
        );
        
        $table_pws_billingo_partnerhash->addColumn(
            'hash',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'hash'
        );

        $setup->getConnection()->createTable($table_pws_billingo_billingo);
        $setup->getConnection()->createTable($table_pws_billingo_partnerhash);

        $setup->endSetup();
    }
}

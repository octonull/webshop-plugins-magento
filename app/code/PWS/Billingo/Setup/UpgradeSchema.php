<?php

namespace PWS\Billingo\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();

        $table_pws_billingo_partnerhash = $setup->getConnection()->newTable($setup->getTable('pws_billingo_partnerhash'));
        
        $table_pws_billingo_partnerhash->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,'auto_increment' => true],
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

        $setup->getConnection()->createTable($table_pws_billingo_partnerhash);

        $setup->endSetup();
    }
}

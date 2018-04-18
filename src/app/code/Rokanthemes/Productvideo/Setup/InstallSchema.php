<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $installer = $setup;
        $installer->startSetup();

        // Get rokantheme_productvideo table
        $tableName = $installer->getTable('rokantheme_productvideo');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create rokantheme_productvideo table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'video_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true,
                        'length' => 10
                    ],
                    'video_id'
                )
                ->addColumn(
                    'type',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'type'
                )
				->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'code'
                )
				->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'title'
                )
				->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'description'
                )
				->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'image'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1', 'length' => 1],
                    'status'
                )
                ->setComment('Videos')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        // Get rokantheme_productvideo_store table
        $tableName = $installer->getTable('rokantheme_productvideo_store');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create rokantheme_productvideo_store table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'video_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'length' => 10,
                        'primary'   => true,
                    ],
                    'video_id'
                )
                ->addColumn(
                    'store_id',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'length' => 5,
                        'primary'   => true,
                    ],
                    'store_id'
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'rokantheme_productvideo_store',
                        'video_id',
                        'rokantheme_productvideo',
                        'video_id'
                    ),
                    'video_id',
                    $installer->getTable('rokantheme_productvideo'),
                    'video_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'rokantheme_productvideo_store',
                        'store_id',
                        'store',
                        'store_id'
                    ),
                    'store_id',
                    $installer->getTable('store'),
                    'store_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->setComment('Productvideo Stores')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
	
		// Get rokantheme_productvideo_productvideo table
        $tableName = $installer->getTable('rokantheme_productvideo_productvideo');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create rokantheme_productvideo_productvideo table
            $table = $installer->getConnection()
                ->newTable($tableName)
				->addColumn(
                    'product_video_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
						'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'length' => 10,
                        'primary'   => true,
                    ],
                    'product_video_id'
                )
                ->addColumn(
                    'video_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'length' => 10
                    ],
                    'video_id'
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'length' => 10
                    ],
                    'product_id'
                )
                ->setComment('rokantheme productvideo productvideo')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
		
        $installer->endSetup();
    }
}

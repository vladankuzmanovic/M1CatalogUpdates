<?php
/**
 * @author      Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('kdcatalogupdates/log'))
    ->addColumn(
        'id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Log ID')
    ->addColumn(
        'pid', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Product Id')
    ->addColumn(
        'attr_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Product Attribute ID')
    ->addColumn(
        'old_val', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'Old Attribute Value')
    ->addColumn(
        'new_val', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'New Attribute Value')
    ->addIndex(
        $installer->getIdxName(
            'kdcatalogupdates/log', array('pid', 'attr_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('pid', 'attr_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addForeignKey($installer->getFkName('kdcatalogupdates/log', 'pid', 'catalog/product', 'entity_id'),
        'pid', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('kdcatalogupdates/log', 'attr_id', 'eav/attribute', 'attribute_id'),
        'attr_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Notifications log Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
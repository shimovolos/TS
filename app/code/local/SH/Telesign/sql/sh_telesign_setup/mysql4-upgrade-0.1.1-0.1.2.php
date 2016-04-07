<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'sh_telesign_transactions'
 */
if(!$installer->getConnection()->isTableExists('sh_telesign_transactions')) {
    $table = $installer->getConnection()
        ->newTable('sh_telesign_transactions')
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'auto_increment'  => true,
            'unsigned'        => true,
            'nullable'        => false,
            'primary'         => true,
        ), 'Entity ID')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Customer ID')
        ->addColumn('telephone', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Telephone')
        ->addColumn('notification_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Notification Type')
        ->addColumn('verify_code', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Verify Code')
        ->addColumn('confirm_verify_code', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => true,
        ), 'Confirm Verify Code')
        ->addColumn('transaction_code', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => true,
            'default'   => null,
        ), 'Transaction Code')
        ->addColumn('resend_code', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Transaction Code')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'unsigned'  => true,
            'nullable'  => true,
            'default'   => null
        ), 'Created At')
        ->addIndex($installer->getIdxName('sh_telesign_transactions', array('customer_id')),
            array('customer_id'))
        ->addIndex($installer->getIdxName('sh_telesign_transactions', array('telephone')),
            array('telephone'))
        ->addIndex($installer->getIdxName('sh_telesign_transactions', array('notification_type')),
            array('notification_type'))
        ->addForeignKey($installer->getFkName('sh_telesign_transactions', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id', 'customer_entity', 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Telesign Core Table');
    $installer->getConnection()->createTable($table);
}

/**
 * Create table 'sh_telesign_telephone_base'
 */
if(!$installer->getConnection()->isTableExists('sh_telesign_telephone_base')) {
    $table = $installer->getConnection()
        ->newTable('sh_telesign_telephone_base')
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'auto_increment'  => true,
            'unsigned'        => true,
            'nullable'        => false,
            'primary'         => true,
        ), 'Entity ID')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Customer ID')
        ->addColumn('telephone', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Telephone')
        ->addColumn('notification_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Notification Type')
        ->addIndex($installer->getIdxName('sh_telesign_telephone_base', array('customer_id')),
            array('customer_id'))
        ->addIndex($installer->getIdxName('sh_telesign_telephone_base', array('telephone')),
            array('telephone'))
        ->addIndex($installer->getIdxName('sh_telesign_telephone_base', array('notification_type')),
            array('notification_type'))
        ->addForeignKey($installer->getFkName('sh_telesign_telephone_base', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id', 'customer_entity', 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName('sh_telesign_telephone_base', 'telephone', 'sh_telesign_transactions', 'telephone'),
            'telephone', 'sh_telesign_transactions', 'telephone',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Telesign Telephone Base Table');
    $installer->getConnection()->createTable($table);
}

/**
 * Create table 'sh_telesign_risk'
 */
if(!$installer->getConnection()->isTableExists('sh_telesign_risk')) {
    $table = $installer->getConnection()
        ->newTable('sh_telesign_risk')
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'auto_increment'  => true,
            'unsigned'        => true,
            'nullable'        => false,
            'primary'         => true,
        ), 'Entity ID')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Customer ID')
        ->addColumn('telephone', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Telephone')
        ->addColumn('notification_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Notification Type')
        ->addColumn('risk', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Verify Code')
       ->addColumn('transaction_code', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => true,
            'default'   => null,
        ), 'Transaction Code')
        ->addColumn('next_check_data', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'unsigned'  => true,
            'nullable'  => true,
            'default'   => null
        ), 'Next Check Date')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'unsigned'  => true,
            'nullable'  => true,
            'default'   => null
        ), 'Created At')
        ->addIndex($installer->getIdxName('sh_telesign_risk', array('customer_id')),
            array('customer_id'))
        ->addIndex($installer->getIdxName('sh_telesign_risk', array('telephone')),
            array('telephone'))
        ->addIndex($installer->getIdxName('sh_telesign_risk', array('notification_type')),
            array('notification_type'))
        ->addForeignKey($installer->getFkName('sh_telesign_risk', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id', 'customer_entity', 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName('sh_telesign_risk', 'telephone', 'sh_telesign_transactions', 'telephone'),
            'telephone', 'sh_telesign_transactions', 'telephone',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Telesign Risk Table');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
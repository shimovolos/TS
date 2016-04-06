<?php
 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->setConfigData('sh_telesign_settings/enablings/customer_edit_address', 0);
$installer->setConfigData('sh_telesign_settings/enablings/checkout', 0);
$installer->setConfigData('sh_telesign_settings/enablings/customer_register', 0);
$installer->setConfigData('sh_telesign_settings/enablings/guest_checkout', 0);

$installer->endSetup();
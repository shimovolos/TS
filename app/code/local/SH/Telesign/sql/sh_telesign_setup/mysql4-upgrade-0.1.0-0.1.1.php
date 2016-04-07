<?php
 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->setConfigData('sh_telesign_settings/enablings/customer_edit_address', 1);
$installer->setConfigData('sh_telesign_settings/enablings/checkout', 1);
$installer->setConfigData('sh_telesign_settings/enablings/customer_register', 1);
$installer->setConfigData('sh_telesign_settings/enablings/guest_checkout', 1);

$installer->setConfigData('sh_telesign_settings/general/notification_type', 2);
$installer->setConfigData('sh_telesign_settings/register_page_settings/customer_register_address_type', 1);
$installer->setConfigData('sh_telesign_settings/general/telephone_from_address', Mage_Customer_Model_Address_Abstract::TYPE_BILLING);
$installer->setConfigData('sh_telesign_settings/register_page_settings/front_telephone_parsing', 0);

$installer->setConfigData('design/theme/locale', 'sh_telesign');
$installer->setConfigData('design/theme/template', 'sh_telesign');
$installer->setConfigData('design/theme/skin', 'sh_telesign');
$installer->setConfigData('design/theme/layout', 'sh_telesign');

$installer->setConfigData('sh_telesign_settings/register_page_settings/enable_address_on_register', '1');

$installer->endSetup();
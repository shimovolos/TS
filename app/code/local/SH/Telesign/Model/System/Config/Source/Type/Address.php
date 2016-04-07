<?php

/**
 * Class SH_Telesign_Model_System_Config_Source_Type_Address
 */
class SH_Telesign_Model_System_Config_Source_Type_Address
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => Mage_Customer_Model_Address_Abstract::TYPE_BILLING, 'label'  => Mage::helper('sh_telesign')->__('Billing')),
            array('value' => Mage_Customer_Model_Address_Abstract::TYPE_SHIPPING, 'label' => Mage::helper('sh_telesign')->__('Shipping')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            Mage_Customer_Model_Address_Abstract::TYPE_BILLING  => Mage::helper('sh_telesign')->__('Billing'),
            Mage_Customer_Model_Address_Abstract::TYPE_SHIPPING => Mage::helper('sh_telesign')->__('Shipping'),
        );
    }
}
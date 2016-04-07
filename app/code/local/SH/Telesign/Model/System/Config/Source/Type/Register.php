<?php

/**
 * Class SH_Telesign_Model_System_Config_Source_Type_Register
 */
class SH_Telesign_Model_System_Config_Source_Type_Register
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => Mage::helper('sh_telesign')->__('Full Address')),
            array('value' => 0, 'label' => Mage::helper('sh_telesign')->__('Only Telephone')),
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
            1 => Mage::helper('sh_telesign')->__('Full Address'),
            0 => Mage::helper('sh_telesign')->__('Only Telephone'),
        );
    }
}
<?php

/**
 * Class SH_Telesign_Helper_Data
 */
class SH_Telesign_Helper_Data extends Mage_Core_Helper_Abstract 
{

    /**
     * @return mixed
     */
    public function isTelesignEnableOnRegister()
    {
        return Mage::getStoreConfig('sh_telesign_settings/enablings/customer_register');
    }

    /**
     * @return mixed
     */
    public function isTelesignEnableOnEditAddress()
    {
        return Mage::getStoreConfig('sh_telesign_settings/enablings/customer_edit_address');
    }

    /**
     * @return mixed
     */
    public function isTelesignEnableOnCheckout()
    {
        return Mage::getStoreConfig('sh_telesign_settings/enablings/checkout');
    }

    /**
     * @return mixed
     */
    public function isTelesignEnableOnGuestCheckout()
    {
        return Mage::getStoreConfig('sh_telesign_settings/enablings/guest_checkout');
    }
}
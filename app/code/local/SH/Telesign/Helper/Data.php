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

    /**
     * @return mixed
     */
    public function telesignNotificationType()
    {
        return Mage::getStoreConfig('sh_telesign_settings/general/notification_type');
    }

    /**
     * @return mixed
     */
    public function isEnableAddressOnRegisterPage()
    {
        return Mage::getStoreConfig('sh_telesign_settings/register_page_settings/enable_address_on_register');
    }

    /**
     * @return mixed
     */
    public function isFullAddressDuringRegistration()
    {
        return Mage::getStoreConfig('sh_telesign_settings/register_page_settings/customer_register_address_type');
    }

    /**
     * @return mixed
     */
    public function addressTypeForTelephone()
    {
        return Mage::getStoreConfig('sh_telesign_settings/general/telephone_from_address');
    }

    /**
     * @return mixed
     */
    public function frontendTelephoneValidation()
    {
        return Mage::getStoreConfig('sh_telesign_settings/register_page_settings/front_telephone_parsing');
    }
}
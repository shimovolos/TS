<?php

/**
 * Class SH_Telesign_Helper_Customer
 */
class SH_Telesign_Helper_Customer extends Mage_Core_Helper_Abstract
{
    /**
     * @return Mage_Customer_Model_Session
     */
    public function getCurrentCustomerSession()
    {
        return Mage::getSingleton('customer/session');
    }

    /**
     * @return Mage_Customer_Model_Customer
     */
    public function getCurrentCustomer()
    {
        return $this->getCurrentCustomerSession()->getCustomer();
    }

    /**
     * @return Mage_Customer_Model_Address|null
     */
    public function getCustomerDefaultBillingAddress()
    {
        $customerDefaultBillingAddress = null;
        $customerDefaultBillingAddressId = $this->getCurrentCustomer()->getDefaultBilling();
        if ($customerDefaultBillingAddressId) {
            $customerDefaultBillingAddress = Mage::getModel('customer/address')->load($customerDefaultBillingAddressId);
            $customerDefaultBillingAddress->getData();
        }

        return $customerDefaultBillingAddress;
    }

    /**
     * @return Mage_Customer_Model_Address|null
     */
    public function getCustomerDefaultShippingAddress()
    {
        $customerDefaultShippingAddress = null;
        $customerDefaultShippingAddressId = $this->getCurrentCustomer()->getDefaultShipping();
        if ($customerDefaultShippingAddressId) {
            $customerDefaultShippingAddress = Mage::getModel('customer/address')->load($customerDefaultShippingAddressId);
            $customerDefaultShippingAddress->getData();
        }

        return $customerDefaultShippingAddress;
    }
}
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
     * @param $addressType
     * @param $customerId
     * @return Mage_Customer_Model_Address|null
     */
    public function getCustomerDefaultAddress($addressType, $customerId)
    {
        $customerDefaultAddress = null;

        if($customerId) {
            /** @var $customerModel Mage_Customer_Model_Customer */
            $customerModel = Mage::getModel('customer/customer');
            $customerModel->load($customerId);

            if($addressType == Mage_Customer_Model_Address_Abstract::TYPE_BILLING) {
                $customerDefaultAddressId = $customerModel->getDefaultBilling();
            } else {
                $customerDefaultAddressId = $customerModel->getDefaultShipping();
            }

            if ($customerDefaultAddressId) {
                $customerDefaultAddress = Mage::getModel('customer/address')->load($customerDefaultAddressId);
                $customerDefaultAddress->getData();
            }
        }

        return $customerDefaultAddress;
    }
}
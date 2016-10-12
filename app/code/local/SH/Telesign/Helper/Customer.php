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

    /**
     * Set telesign values to customer session
     * @param $request
     */
    public function setCustomerSessionWithTelesign($request)
    {
        $session = $this->getCurrentCustomerSession();

        $session->unsetData('telephone');
        $session->unsetData('telesign_notification_type');
        $session->unsetData('telesign_notification_type_label');
        $session->unsetData('telesign_message_language');

        $telephone = $request->getParam('telephone');
        $telesignType = $request->getParam('telesign_type');
        
        $session->setData('telesign_notification_type', $telesignType);
        $session->setData('telesign_message_language', $request->getParam('telesign_message_language'));

        $notifications = new SH_Telesign_Model_System_Config_Source_Type_Notification();
        $notificationsArray = $notifications->toArray();
        $session->setData('telesign_notification_type_label', $notificationsArray[$telesignType]);

        if (empty($telephone)) {
            $message = Mage::helper('sh_telesign/messages')->errorEmptyTelephone();
            $this->telephoneValidationError($message);
        } else {
            $session->setData('telephone', $telephone);
        }
    }

    /**
     * Redirect to previous page with notification, that Telephone field is Required
     * @param $message
     */
    public function telephoneValidationError($message)
    {
        $errUrl = Mage::getUrl('*/*/create', array('_secure' => true));
        $errorUrl = Mage::app()->getRequest()->getParam(Mage_Core_Controller_Varien_Action::PARAM_NAME_ERROR_URL);
        if (empty($errorUrl)) {
            $errorUrl = $errUrl;
        }

        Mage::app()->getFrontController()->getAction()
            ->setFlag(Mage::app()->getRequest()->getActionName(), Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);

        Mage::app()->getResponse()->setRedirect($errorUrl);
        Mage::getSingleton('core/session')->addError(Mage::helper('sh_telesign')->__($message));
        return;
    }
}
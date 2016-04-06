<?php

/**
 * Class SH_Telesign_Model_Customer_Observer
 */
class SH_Telesign_Model_Customer_Observer
{

    /**
     * @event customer_register_success
     * @param Varien_Event_Observer $event
     */
    public function sendCustomerNotificationViaTelesignAfterRegister(Varien_Event_Observer $event)
    {
        $currentCustomer = Mage::helper('sh_telesign/customer')->getCurrentCustomer();
    }

    /**
     * @event controller_action_predispatch
     * @param $event
     */
    public function hookToControllerActionPreDispatch(Varien_Event_Observer $event)
    {
        if($event->getEvent()->getControllerAction()->getFullActionName() == 'customer_account_index') {
            Mage::dispatchEvent('check_telesign_confirmation_before_login', array('request' => $event->getEvent()->getControllerAction()->getRequest()));
        }
    }

    /**
     * @event check_telesign_confirmation_before_login|customer_login
     * @param Varien_Event_Observer $event
     */
    public function checkTelesignConfirmationBeforeLogin(Varien_Event_Observer $event)
    {
        $confirmation = true;
        if(!$confirmation) {
            Mage::helper('sh_telesign/customer')->getCurrentCustomerSession()->logout();
        }
    }
}
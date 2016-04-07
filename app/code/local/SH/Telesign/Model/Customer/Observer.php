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
        if(Mage::helper('sh_telesign')->isTelesignEnableOnRegister()) {

            /** @var $customer Mage_Customer_Model_Customer */
            $customer = $event->getCustomer();

            $telephone = Mage::helper('sh_telesign')->isFullAddressDuringRegistration() ?
                Mage::helper('sh_telesign/customer')
                    ->getCustomerDefaultAddress(Mage::helper('sh_telesign')->addressTypeForTelephone(), $customer->getId())
                    ->getData('telephone') :
                Mage::getSingleton('customer/session')->getData('telesign_telephone');

            $telesignNotificationType = Mage::getSingleton('customer/session')->getData('telesign_notification_type');
            $telesignNotificationTypeLabel = Mage::getSingleton('customer/session')->getData('telesign_notification_type_label');

            if(empty($telephone)) {
                $errorEmptyTelephoneNumberMessage = "Telephone field can't be empty";
                $this->_telephoneValidationError($errorEmptyTelephoneNumberMessage);
            } else {
                preg_match('/[0-9]*$/', $telephone, $telephoneNumber);

                /** @var $telesignTelephoneBase SH_Telesign_Model_Telephone_Base */
                $telesignTelephoneBase = Mage::getModel('sh_telesign/telephone_base');

                //Check if telephone number already exists
                $exist = $telesignTelephoneBase->existTelephone(current($telephoneNumber));
                if($exist) {
                    $errorExistTelephoneNumberMessage = "Telephone number already exists";
                    $this->_telephoneValidationError($errorExistTelephoneNumberMessage);
                } else {
                    $telesignTelephoneBase->setData(array(
                        'customer_id'       => $customer->getId(),
                        'telephone'         => $telephone,
                        'notification_type' => $telesignNotificationType
                    ));

                    try {
                        $telesignTelephoneBase->save();
                        $successTelesignMessage = Mage::helper('sh_telesign')
                            ->__("Your verification code was sent according to the selected type: %s", $telesignNotificationTypeLabel);

                        //Core Telesign Model
                        Mage::getModel('sh_telesign/telesign', array(
                                'notificationType' => $telesignNotificationType,
                                'customerId'       => $customer->getId(),
                                'telephone'        => $telephone,
                                'notificationLabel'=> $telesignNotificationTypeLabel,
                            )
                        );

                        Mage::dispatchEvent('check_telesign_confirmation_before_login', array(
                            'confirmation'  => false,
                            'message'       => $successTelesignMessage,
                        ));
                    } catch (Exception $e) {
                        Mage::log($e->getMessage(), null, 'telesign.log');
                    }
                }
            }
        }
    }

    /**
     * @event controller_action_predispatch
     * @param $event
     */
    public function hookToControllerActionPreDispatch(Varien_Event_Observer $event)
    {
        $actionFullName = $event->getEvent()->getControllerAction()->getFullActionName();

        //Event before customer login
        if($actionFullName == 'customer_account_index') {
            Mage::dispatchEvent('check_telesign_confirmation_before_login', array(
                'request' => $event->getEvent()->getControllerAction()->getRequest()
            ));
        }

        //Event before creating customer account
        if($actionFullName == 'customer_account_createpost') {
            if(Mage::helper('sh_telesign')->isTelesignEnableOnRegister() &&
                !Mage::helper('sh_telesign')->isFullAddressDuringRegistration()) {

                $session = Mage::helper('sh_telesign/customer')->getCurrentCustomerSession();

                $session->unsetData('telesign_telephone');
                $session->unsetData('telesign_notification_type');
                $session->unsetData('telesign_notification_type_label');

                $telephone = Mage::app()->getRequest()->getParam('telesign_telephone');
                $telesignType = Mage::app()->getRequest()->getParam('telesign_type');
                $session->setData('telesign_notification_type', $telesignType);

                $notifications = new SH_Telesign_Model_System_Config_Source_Type_Notification();
                $notificationsArray = $notifications->toArray();
                $session->setData('telesign_notification_type_label', $notificationsArray[$telesignType]);

                if (empty($telephone)) {
                    $message = "Telephone field can't be empty";
                    $this->_telephoneValidationError($message);
                } else {
                    $session->setData('telesign_telephone', $telephone);
                }
            }
        }
    }

    /**
     * @event check_telesign_confirmation_before_login|customer_login
     * @param Varien_Event_Observer $event
     */
    public function checkTelesignConfirmationBeforeLogin(Varien_Event_Observer $event)
    {
        $confirmation = $event->getEvent()->getData('confirmation');
        $message = $event->getEvent()->getData('message');
        if(!$confirmation) {
            $session = Mage::helper('sh_telesign/customer')->getCurrentCustomerSession();
            $session->setCustomer(Mage::getModel('customer/customer'))->setId(null);
            $session->addSuccess($message);
            $session->logout();
        }
    }

    /**
     * Redirect to previous page with notification, that Telephone field is Required
     * @param $message
     */
    private function _telephoneValidationError($message)
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
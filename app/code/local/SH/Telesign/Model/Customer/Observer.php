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
    public function enableTelesignVerificationAfterRegister(Varien_Event_Observer $event)
    {
        if (Mage::helper('sh_telesign')->isTelesignEnableOnRegister()) {

            /** @var $messageHelper SH_Telesign_Helper_Messages */
            $messageHelper = Mage::helper('sh_telesign/messages');

            /** @var $customer Mage_Customer_Model_Customer */
            $customer = $event->getCustomer();

            $telephone = Mage::helper('sh_telesign')->isFullAddressDuringRegistration() ?
                Mage::helper('sh_telesign/customer')
                    ->getCustomerDefaultAddress(Mage::helper('sh_telesign')->addressTypeForTelephone(), $customer->getId())
                    ->getData('telephone') :
                Mage::getSingleton('customer/session')->getData('telephone');

            $telesignNotificationType = Mage::getSingleton('customer/session')->getData('telesign_notification_type');
            $telesignNotificationTypeLabel = Mage::getSingleton('customer/session')->getData('telesign_notification_type_label');


            if (empty($telephone)) {
                Mage::helper('sh_telesign/customer')->telephoneValidationError($messageHelper->errorEmptyTelephone());
            } else {
                preg_match('/[0-9]*$/', $telephone, $telephoneNumber);

                /** @var $telesignTelephoneBase SH_Telesign_Model_Telephone_Base */
                $telesignTelephoneBase = Mage::getModel('sh_telesign/telephone_base');

                //Check if telephone number already exists
                $exist = $telesignTelephoneBase->existTelephone(current($telephoneNumber));
                if ($exist) {
                    Mage::helper('sh_telesign/customer')->telephoneValidationError($messageHelper->errorExistTelephone());
                } else {
                    $modelsData = [
                        'customer_id'       => $customer->getId(),
                        'telephone'         => $telephone,
                        'notification_type' => $telesignNotificationType
                    ];

                    $telesignTelephoneBase->setData($modelsData);

                    try {
                        //Save Transaction
                        /** @var $transactionModel SH_Telesign_Model_Transactions */
                        $transactionModel = Mage::getModel('sh_telesign/transactions');

                        $modelsData['notificationLabel'] = $telesignNotificationTypeLabel;

                        $transactionModel->saveTransaction($modelsData);

                        try {
                            $telesignTelephoneBase->save();
                        } catch (Exception $e) {
                            Mage::throwException($e->getMessage());
                        }

                        Mage::dispatchEvent('check_telesign_confirmation_before_login', [
                            'confirmation'      => false,
                            'message'           => $messageHelper->successSendCode($telesignNotificationTypeLabel),
                            'register_telesign' => true,
                        ]);
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
        if ($actionFullName == 'customer_account_index') {
            Mage::dispatchEvent('check_telesign_confirmation_before_login', [
                'request' => $event->getEvent()->getControllerAction()->getRequest()
            ]);
        }

        //Event before creating customer account
        if ($actionFullName == 'customer_account_createpost') {
            if (Mage::helper('sh_telesign')->isTelesignEnableOnRegister()) {

                Mage::helper('sh_telesign/customer')->setCustomerSessionWithTelesign(Mage::app()->getRequest());

            }
        }
    }

    /**
     * @event check_telesign_confirmation_before_login|customer_login
     * @param Varien_Event_Observer $event
     */
    public function checkTelesignConfirmationBeforeLogin(Varien_Event_Observer $event)
    {
        if($event->getEvent()->getData('register_telesign')) {
            $confirmation = $event->getEvent()->getData('confirmation');

            if (!$confirmation) {
                $session = Mage::helper('sh_telesign/customer')->getCurrentCustomerSession();
                $session->setCustomer(Mage::getModel('customer/customer'))->setId(null);

                $message = $event->getEvent()->getData('message');
                $session->addSuccess($message);

                $session->logout();
            }
        }
    }
}
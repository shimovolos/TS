<?php

/**
 * Class SH_Telesign_VerifyController
 */
class SH_Telesign_VerifyController extends Mage_Core_Controller_Front_Action
{
    public function resendFormAction()
    {
        $this->loadLayout();

        $layout = $this->getLayout();
        $layout->getBlock('head')->setTitle($this->__('Resend Verify Code'));

        $this->renderLayout();
    }

    public function resendCodeAction()
    {
        $data = $this->getRequest()->getParams();

        if($data) {
            $email = $data['username'];

            if($data['verify_code_telephone']) {
                $newTelephone = $data['verify_code_new_telephone'];
                $customer = $this->_customer($email);

                $addressId = Mage::helper('sh_telesign')->addressTypeForTelephone() == 'shipping' ?
                    $customer->getDefaultShippingAddress()->getId() :
                    $customer->getDefaultBillingAddress()->getId();

                $address = Mage::getModel('customer/address')->load($addressId);

                $address->setData('telephone', $newTelephone);

                try {
                    $address->save();
                } catch (Exception $e) {
                    Mage::throwException($e->getMessage());
                }

                //toDo resend verify code

                Mage::getModel('sh_telesign/transactions')->load($customer->getId(), 'customer_id')->updateTransactionResendPhone($newTelephone);
                Mage::getSingleton('core/session')->addSuccess($this->__(Mage::helper('sh_telesign/messages')->successResendCode()));
            } else {
                //toDo resend verify code
            }
        }

        $this->_redirectUrl(Mage::getUrl('customer/account/login'));
    }

    /**
     * @param $email
     * @return Mage_Customer_Model_Customer
     */
    private function _customer($email)
    {
        $websiteId = Mage::app()->getWebsite()->getId();
        $customer = Mage::getModel('customer/customer')->setWebsiteId($websiteId)->loadByEmail($email);

        return $customer;
    }
}
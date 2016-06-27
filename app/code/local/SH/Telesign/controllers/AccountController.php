<?php

require_once 'Mage/Customer/controllers/AccountController.php';


class SH_Telesign_AccountController extends Mage_Customer_AccountController
{
    /**
     * Default customer account page
     */
    public function indexAction()
    {
        $isLogin = Mage::helper('sh_telesign/verify')->verifyCode($this->_getSession()->getCustomer()->getId(), $this->getRequest()->getParam('verify_code'));

        if($isLogin || (!$isLogin && !Mage::helper('sh_telesign')->isTelesignEnableOnRegister())) {
            $this->loadLayout();
            $this->_initLayoutMessages('customer/session');
            $this->_initLayoutMessages('catalog/session');

            $this->getLayout()->getBlock('content')->append(
                $this->getLayout()->createBlock('customer/account_dashboard')
            );
            $this->getLayout()->getBlock('head')->setTitle($this->__('My Account'));
            $this->renderLayout();
        } else {
            $this->_getSession()->logout();
        }
    }

    /**
     * Customer login form page
     */
    public function loginAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $this->getResponse()->setHeader('Login-Required', 'true');
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
    }

    /**
     * Login post action
     */
    public function loginPostAction()
    {
        if (!$this->_validateFormKey()) {
            $this->_redirect('*/*/');
            return;
        }

        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $session = $this->_getSession();

        if ($this->getRequest()->isPost()) {

            $login = $this->getRequest()->getPost('login');

            if (!empty($login['username']) && !empty($login['password'])) {
                try {
                    $session->login($login['username'], $login['password']);

                    if(Mage::helper('sh_telesign')->isTelesignEnableOnRegister()) {
                        $isLogin = Mage::helper('sh_telesign/verify')->verifyCode($session->getCustomer()->getId(), $this->getRequest()->getParam('verify_code'));

                        if ($isLogin) {
                            if ($session->getCustomer()->getIsJustConfirmed()) {
                                $this->_welcomeCustomer($session->getCustomer(), true);
                            }
                        } else {
                            $session->setCustomer(Mage::getModel('customer/customer'))->setId(null);
                            $session->addError($this->__(Mage::helper('sh_telesign/messages')->errorVerifyTelephone()));

                            $session->logout();
                            $this->_redirectReferer();

                        }
                    } else {
                        if ($session->getCustomer()->getIsJustConfirmed()) {
                            $this->_welcomeCustomer($session->getCustomer(), true);
                        }
                    }

                } catch (Mage_Core_Exception $e) {
                    switch ($e->getCode()) {
                        case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                            $value = $this->_getHelper('customer')->getEmailConfirmationUrl($login['username']);
                            $message = $this->_getHelper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                            break;
                        case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                            $message = $e->getMessage();
                            break;
                        default:
                            $message = $e->getMessage();
                    }
                    $session->addError($message);
                    $session->setUsername($login['username']);
                } catch (Exception $e) {
                    // Mage::logException($e); // PA DSS violation: this exception log can disclose customer password
                }
            } else {
                $session->addError($this->__('Login and password are required.'));
            }
        }

        $this->_loginPostRedirect();
    }
}
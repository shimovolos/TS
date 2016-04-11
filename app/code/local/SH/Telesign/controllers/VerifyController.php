<?php

/**
 * Class SH_Telesign_VerifyController
 */
class SH_Telesign_VerifyController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();

        $layout = $this->getLayout();
        $layout->getBlock('head')->setTitle($this->__('Registration Verify Code'));

        $this->renderLayout();
    }

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

        var_dump($data);exit;
    }
}
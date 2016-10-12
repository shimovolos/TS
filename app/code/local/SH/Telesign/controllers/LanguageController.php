<?php

/**
 * Class SH_Telesign_LanguageController
 */
class SH_Telesign_LanguageController extends Mage_Core_Controller_Front_Action
{
    public function notificationLanguageAction()
    {
        $type = Mage::app()->getRequest()->getParam('notification_type');

        $this->getLayout()->unsetBlock('customer.form.register.telesign.language');

        $block = $this->getLayout()->createBlock('sh_telesign/language')
            ->setData('notificationType', $type)
            ->setTemplate('persistent/customer/form/telesign/language.phtml');

        $this->getResponse()->setBody($block->toHtml());
    }
}
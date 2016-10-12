<?php

/**
 * Class SH_Telesign_Helper_Messages
 */
class SH_Telesign_Helper_Api_Settings extends Mage_Core_Helper_Abstract
{
    /**
     * @return mixed
     */
    public function apiCustomerId()
    {
        return Mage::getStoreConfig('sh_telesign_api/settings/customer_id');
    }

    /**
     * @return mixed
     */
    public function apiRestKey()
    {
        return Mage::getStoreConfig('sh_telesign_api/settings/key');
    }

    /**
     * @return mixed|null
     */
    public function apiSmsTemplate()
    {
        $useDefault = Mage::getStoreConfig('sh_telesign_api/sms_settings/use_default_message');

        return $useDefault ? null : Mage::getStoreConfig('sh_telesign_api/sms_settings/message_template');
    }

    /**
     * @return mixed|null
     */
    public function apiCallTextToSpeechTemplate()
    {
        $useDefault = Mage::getStoreConfig('sh_telesign_api/call_settings/use_default_tts_message');

        return $useDefault ? null : Mage::getStoreConfig('sh_telesign_api/call_settings/message_template');
    }
}
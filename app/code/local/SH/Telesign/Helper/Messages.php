<?php

/**
 * Class SH_Telesign_Helper_Messages
 */
class SH_Telesign_Helper_Messages extends Mage_Core_Helper_Abstract
{
    /**
     * @return string
     */
    public function errorEmptyTelephone()
    {
        return "Telephone field can't be empty.";
    }

    /**
     * @return string
     */
    public function errorExistTelephone()
    {
        return "Telephone number already exists.";
    }

    /**
     * @return string
     */
    public function errorVerifyTelephone()
    {
        return "Wrong verification code.";
    }

    /**
     * @param $telesignNotificationTypeLabel
     * @return string
     */
    public function successSendCode($telesignNotificationTypeLabel)
    {
        $successTelesignMessage = Mage::helper('sh_telesign')
            ->__("Your verification code was sent according to the selected type: %s", $telesignNotificationTypeLabel);

        return $successTelesignMessage;
    }

    /**
     * @return string
     */
    public function successResendCode()
    {
        return 'Verification code was resend';
    }
}
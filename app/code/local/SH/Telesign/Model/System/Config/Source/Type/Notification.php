<?php

/**
 * Class SH_Telesign_Model_System_Config_Source_Type_Notification
 */
class SH_Telesign_Model_System_Config_Source_Type_Notification
{
    const TELESIGN_TYPE_SMS = 0;
    const TELESIGN_TYPE_CALL = 1;
    const TELESIGN_TYPE_BOTH = 2;
    const TELESIGN_TYPE_PHONE_VERIFICATION = 3;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::TELESIGN_TYPE_SMS, 'label' => Mage::helper('sh_telesign')->__('SMS')),
            array('value' => self::TELESIGN_TYPE_CALL, 'label' => Mage::helper('sh_telesign')->__('Call')),
            array('value' => self::TELESIGN_TYPE_BOTH, 'label' => Mage::helper('sh_telesign')->__('Both types')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            self::TELESIGN_TYPE_SMS => Mage::helper('sh_telesign')->__('SMS'),
            self::TELESIGN_TYPE_CALL => Mage::helper('sh_telesign')->__('Call'),
            self::TELESIGN_TYPE_BOTH => Mage::helper('sh_telesign')->__('Both types'),
        );
    }

    /**
     * @return array
     */
    public function getCurrentNotificationType()
    {
        $currentNotificationType = Mage::getStoreConfig('sh_telesign_settings/general/notification_type');
        $optionArray = $this->toArray();
        $currentNotificationTypeArray = array();

        if($currentNotificationType == self::TELESIGN_TYPE_BOTH) {
            unset($optionArray[self::TELESIGN_TYPE_BOTH]);
            $currentNotificationTypeArray = $optionArray;
        } elseif($currentNotificationType == self::TELESIGN_TYPE_CALL) {
            $currentNotificationTypeArray[] = $optionArray[self::TELESIGN_TYPE_CALL];
        } elseif($currentNotificationType == self::TELESIGN_TYPE_SMS) {
            $currentNotificationTypeArray[] = $optionArray[self::TELESIGN_TYPE_SMS];
        }

        return $currentNotificationTypeArray;
    }
}
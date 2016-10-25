<?php

/**
 * Class SH_Telesign_Model_System_Config_Source_Type_Notification
 */
class SH_Telesign_Model_System_Config_Source_Type_Notification
{
    const TELESIGN_TYPE_SMS                = 0;
    const TELESIGN_TYPE_CALL               = 1;
    const TELESIGN_TYPE_BOTH               = 2;
    const TELESIGN_TYPE_PHONE_VERIFICATION = 3;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::TELESIGN_TYPE_SMS, 'label' => Mage::helper('sh_telesign')->__('SMS')],
            ['value' => self::TELESIGN_TYPE_CALL, 'label' => Mage::helper('sh_telesign')->__('Call')],
            ['value' => self::TELESIGN_TYPE_BOTH, 'label' => Mage::helper('sh_telesign')->__('Available Both types')],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @param $exclude
     *
     * @return array
     */
    public function toArray($exclude)
    {
        $types = [
            self::TELESIGN_TYPE_SMS  => Mage::helper('sh_telesign')->__('SMS'),
            self::TELESIGN_TYPE_CALL => Mage::helper('sh_telesign')->__('Call'),
            self::TELESIGN_TYPE_BOTH => Mage::helper('sh_telesign')->__('Available Both types'),
        ];

        if($exclude) {
            unset($types[$exclude]);
        }

        return $types;
    }

    /**
     * @return array
     */
    public function getCurrentNotificationType()
    {
        $currentNotificationType = Mage::getStoreConfig('sh_telesign_settings/general/notification_type');
        $optionArray = $this->toArray();
        $currentNotificationTypeArray = [];

        if ($currentNotificationType == self::TELESIGN_TYPE_BOTH) {
            unset($optionArray[self::TELESIGN_TYPE_BOTH]);
            $currentNotificationTypeArray = $optionArray;
        } elseif ($currentNotificationType == self::TELESIGN_TYPE_CALL) {
            $currentNotificationTypeArray[self::TELESIGN_TYPE_CALL] = $optionArray[self::TELESIGN_TYPE_CALL];
        } elseif ($currentNotificationType == self::TELESIGN_TYPE_SMS) {
            $currentNotificationTypeArray[self::TELESIGN_TYPE_SMS] = $optionArray[self::TELESIGN_TYPE_SMS];
        }

        return $currentNotificationTypeArray;
    }
}
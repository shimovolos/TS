<?php

/**
 * Class SH_Telesign_Model_System_Config_Source_Type_Notification
 */
class SH_Telesign_Model_System_Config_Source_Type_Notification
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label' => Mage::helper('sh_telesign')->__('SMS')),
            array('value' => 1, 'label' => Mage::helper('sh_telesign')->__('Call')),
            array('value' => 2, 'label' => Mage::helper('sh_telesign')->__('Both types')),
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
            0 => Mage::helper('sh_telesign')->__('SMS'),
            1 => Mage::helper('sh_telesign')->__('Call'),
            2 => Mage::helper('sh_telesign')->__('Both types'),
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

        if($currentNotificationType == 2) {
            unset($optionArray[2]);
            $currentNotificationTypeArray = $optionArray;
        } elseif($currentNotificationType == 1) {
            $currentNotificationTypeArray[] = $optionArray[1];
        } elseif($currentNotificationType == 0) {
            $currentNotificationTypeArray[] = $optionArray[0];
        }

        return $currentNotificationTypeArray;
    }
}
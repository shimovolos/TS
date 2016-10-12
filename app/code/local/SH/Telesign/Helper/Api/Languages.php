<?php

/**
 * Class SH_Telesign_Helper_Messages
 */
class SH_Telesign_Helper_Api_Languages extends Mage_Core_Helper_Abstract
{
    const API_LANGUAGE_SMS_CSV  = 'Sms.csv';
    const API_LANGUAGE_CALL_CSV = 'Call.csv';

    /**
     * @param $type
     *
     * @return array|bool
     */
    public function language($type)
    {
        $fileName = ($type == SH_Telesign_Model_System_Config_Source_Type_Notification::TELESIGN_TYPE_CALL) ? self::API_LANGUAGE_CALL_CSV :
            ($type == SH_Telesign_Model_System_Config_Source_Type_Notification::TELESIGN_TYPE_SMS ? self::API_LANGUAGE_SMS_CSV : '');

        if ($fileName) {
            $file = Mage::getModel('core/config_options')->getCodeDir() . DS . 'local' . DS . 'SH' . DS . 'Telesign' . DS . 'data' . DS . 'Api' . DS . 'Languages' . DS . $fileName;

            $csvObject = new Varien_File_Csv();
            try {
                return $csvObject->getDataPairs($file);
            } catch (Exception $e) {
                Mage::log('Csv: ' . $file . ' - get csv data error - ' . $e->getMessage(), Zend_Log::ERR, 'sh_telesign.log', true);

                return false;
            }
        }

    }
}
<?php

/**
 * Class SH_Telesign_Model_Telephone_Base
 */

/**
 * @method string getNotificationType()
 * @method SH_Telesign_Model_Telephone_Base setNotificationType(string $value)
 * @method string getTelephone()
 * @method SH_Telesign_Model_Telephone_Base setTelephone(string $value)
 * @method int getEntityId()
 * @method SH_Telesign_Model_Telephone_Base setEntityId(int $value)
 * @method int getCustomerId()
 * @method SH_Telesign_Model_Telephone_Base setCustomerId(int $value)
 */
class SH_Telesign_Model_Telephone_Base extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('sh_telesign/telephone_base');
    }

    /**
     * @param $telephone
     *
     * @return bool
     */
    public function existTelephone($telephone)
    {
        $exist = false;

        /** @var $telesignTelephoneBaseCollection SH_Telesign_Model_Resource_Telephone_Base_Collection */
        $telesignTelephoneBaseCollection = $this->getCollection()
            ->addFieldToFilter('telephone', ['eq' => $telephone]);

        if ($telesignTelephoneBaseCollection->count() > 0) {
            $exist = true;
        }

        return $exist;
    }
}
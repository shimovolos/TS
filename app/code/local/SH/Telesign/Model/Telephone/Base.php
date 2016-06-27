<?php

/**
 * Class SH_Telesign_Model_Telephone_Base
 */
class SH_Telesign_Model_Telephone_Base extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('sh_telesign/telephone_base');
    }

    /**
     * @param $telephone
     * @return bool
     */
    public function existTelephone($telephone)
    {
        $exist = false;

        /** @var $telesignTelephoneBaseCollection SH_Telesign_Model_Resource_Telephone_Base_Collection */
        $telesignTelephoneBaseCollection = $this->getCollection()
            ->addFieldToFilter('telephone', array('eq' => $telephone));

        if($telesignTelephoneBaseCollection->count() > 0) {
            $exist = true;
        }

        return $exist;
    }
}
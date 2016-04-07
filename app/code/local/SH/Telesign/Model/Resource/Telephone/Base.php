<?php

/**
 * Class SH_Telesign_Model_Resource_Telephone_Base
 */
class SH_Telesign_Model_Resource_Telephone_Base extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('sh_telesign/sh_telesign_telephone_base', 'entity_id');
    }

}
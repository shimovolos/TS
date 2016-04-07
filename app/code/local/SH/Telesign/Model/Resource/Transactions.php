<?php

/**
 * Class SH_Telesign_Model_Resource_Transactions
 */
class SH_Telesign_Model_Resource_Transactions extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('sh_telesign/sh_telesign_transactions', 'entity_id');
    }

}
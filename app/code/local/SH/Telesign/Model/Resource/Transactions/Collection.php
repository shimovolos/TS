<?php

/**
 * Class SH_Telesign_Model_Resource_Transactions_Collection
 */
class SH_Telesign_Model_Resource_Transactions_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('sh_telesign/transactions');
    }

}
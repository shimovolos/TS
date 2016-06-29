<?php

/**
 * Class SH_Telesign_Model_Risk
 */

/**
 * @method string getNotificationType()
 * @method SH_Telesign_Model_Risk setNotificationType(string $value)
 * @method int getTransactionCode()
 * @method SH_Telesign_Model_Risk setTransactionCode(int $value)
 * @method string getNextCheckData()
 * @method SH_Telesign_Model_Risk setNextCheckData(string $value)
 * @method string getCreatedAt()
 * @method SH_Telesign_Model_Risk setCreatedAt(string $value)
 * @method string getTelephone()
 * @method SH_Telesign_Model_Risk setTelephone(string $value)
 * @method int getRisk()
 * @method SH_Telesign_Model_Risk setRisk(int $value)
 * @method int getEntityId()
 * @method SH_Telesign_Model_Risk setEntityId(int $value)
 * @method int getCustomerId()
 * @method SH_Telesign_Model_Risk setCustomerId(int $value)
 */
class SH_Telesign_Model_Risk extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('sh_telesign/risk');
    }

}
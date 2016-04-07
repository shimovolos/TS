<?php

/**
 * Class SH_Telesign_Model_Telesign
 */
class SH_Telesign_Model_Telesign extends Mage_Core_Model_Abstract
{
    protected $_customerId;
    protected $_notificationType;
    protected $_notificationLabel;
    protected $_telephone;

    public function __construct($data)
    {
        $this->_customerId       = $data['customer_id'];
        $this->_notificationType = $data['notification_type'];
        $this->_telephone        = $data['telephone'];
        $this->_notificationLabel= $data['telephone'];
    }
}
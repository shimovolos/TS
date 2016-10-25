<?php

/**
 * Class SH_Telesign_Block_Telephone_Transactions
 */
class SH_Telesign_Block_Telephone_Transactions extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'sh_telesign';
        $this->_controller = 'telephone_transactions';
        $this->_headerText = $this->__('Transactions');

        parent::__construct();

        $this->_removeButton('add');
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}


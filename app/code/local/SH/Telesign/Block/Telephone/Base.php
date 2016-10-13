<?php

/**
 * Class SH_Telesign_Block_Telephone_Base
 */
class SH_Telesign_Block_Telephone_Base extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'sh_telesign';
        $this->_controller = 'telephone_base';
        $this->_headerText = $this->__('Telesign Telephone Base');

        parent::__construct();

        $this->_removeButton('add');
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }
}


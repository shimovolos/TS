<?php

/**
 * Class SH_Telesign_Block_Adminhtml_Customer_Edit_Tabs
 */
class SH_Telesign_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Customer_Edit_Tabs
{
    protected function _beforeToHtml()
    {
        $this->addTabAfter('telesign_transactions', [
            'label' => Mage::helper('customer')->__('Telesign Transactions'),
            'class' => 'ajax',
            'url'   => $this->getUrl('*/telephone_transactions/grid', ['_current' => true]),
        ], 'account');

        parent::_beforeToHtml();

    }
}
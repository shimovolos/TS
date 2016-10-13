<?php

/**
 * Class SH_Telesign_Block_Admin_Telephone_Renderer_Customer
 *
 */
class SH_Telesign_Block_Admin_Telephone_Renderer_Customer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());

        $url = $this->getUrl('*/customer/edit', array('id' => $value));

        $customer = Mage::getModel('customer/customer')->load($value);

        $link = '<a href="' . $url . '">'. $customer->getName() .'</a>';
        return $url ? $link : '';
    }
}
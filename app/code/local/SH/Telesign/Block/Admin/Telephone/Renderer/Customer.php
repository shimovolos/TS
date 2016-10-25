<?php

/**
 * Class SH_Telesign_Block_Admin_Telephone_Renderer_Customer
 *
 */
class SH_Telesign_Block_Admin_Telephone_Renderer_Customer implements Varien_Data_Form_Element_Renderer_Interface
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $id = $element->getEscapedValue();

        $url = Mage::helper('adminhtml')->getUrl('*/customer/edit', ['id' => $id]);

        $customer = Mage::getModel('customer/customer')->load($id);

        $link = '<a href="' . $url . '">' . $customer->getName() . '</a>';
        $link .= '<input hidden name="customer_id" value="' . $id . '"';

        return $url ? $link : '';
    }
}
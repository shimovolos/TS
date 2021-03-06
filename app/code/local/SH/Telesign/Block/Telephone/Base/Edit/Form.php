<?php

class SH_Telesign_Block_Telephone_Base_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _getModel()
    {
        return Mage::registry('current_model');
    }

    protected function _getHelper()
    {
        return Mage::helper('sh_telesign');
    }

    protected function _getModelTitle()
    {
        return 'Telephone Base';
    }

    protected function _prepareForm()
    {
        $model = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        $form = new Varien_Data_Form([
            'id'     => 'edit_form',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post',
        ]);

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => $this->_getHelper()->__("$modelTitle Information"),
            'class'  => 'fieldset',
        ]);

        if ($model && $model->getId()) {
            $modelPk = $model->getResource()->getIdFieldName();
            $fieldset->addField($modelPk, 'hidden', [
                'name' => $modelPk,
            ]);
        }


        $customer = $fieldset->addField('customer_id', 'label', [
            'name'  => 'customer_id',
            'label' => $this->__('Customer'),
            'title' => $this->__('Customer'),
        ]);

        $renderer = new SH_Telesign_Block_Admin_Telephone_Renderer_Customer();
        $customer->setRenderer($renderer);

        $fieldset->addField('telephone', 'text', [
            'name'  => 'telephone',
            'label' => $this->__('Telephone'),
            'title' => $this->__('Telephone'),
            'style' => 'width:100%',
            'readonly' => true,
        ]);

        $fieldset->addField('notification_type', 'select', [
            'name'   => 'notification_type',
            'label'  => $this->__('Notification Type'),
            'title'  => $this->__('Notification Type'),
            'values' => Mage::getModel('sh_telesign/system_config_source_type_notification')
                ->toArray(SH_Telesign_Model_System_Config_Source_Type_Notification::TELESIGN_TYPE_BOTH),
            'disabled' => true,
        ]);


        if ($model) {
            $form->setValues($model->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}

<?php

/**
 * Class SH_Telesign_Block_Telephone_Transactions_Edit
 */
class SH_Telesign_Block_Telephone_Transactions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'sh_telesign';
        $this->_controller = 'telephone_transactions';
        $this->_mode = 'edit';
        $modelTitle = $this->_getModelTitle();
        $this->_updateButton('save', 'label', $this->_getHelper()->__("Save $modelTitle"));
        $this->_addButton('saveandcontinue', [
            'label'   => $this->_getHelper()->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class'   => 'save',
        ], -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    protected function _getHelper()
    {
        return Mage::helper('sh_telesign');
    }

    protected function _getModel()
    {
        return Mage::registry('entity_id');
    }

    protected function _getModelTitle()
    {
        return 'Telesign Transactions';
    }

    public function getHeaderText()
    {
        $model = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        if ($model && $model->getId()) {
            return $this->_getHelper()->__("Edit $modelTitle (ID: {$model->getId()})");
        } else {
            return $this->_getHelper()->__("New $modelTitle");
        }
    }


    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index');
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', [$this->_objectId => $this->getRequest()->getParam($this->_objectId)]);
    }

    /**
     * Get form save URL
     *
     * @deprecated
     * @see getFormActionUrl()
     * @return string
     */
    public function getSaveUrl()
    {
        $this->setData('form_action_url', 'save');

        return $this->getFormActionUrl();
    }


}

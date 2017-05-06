<?php

/**
 * Class SH_Telesign_Block_Telephone_Transactions_Grid
 */
class SH_Telesign_Block_Telephone_Transactions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sh_telesign/transactions')->getCollection();

        $selectCountryAttributeId = 'SELECT attribute_id AS country_id FROM eav_attribute WHERE attribute_code = \'country_id\'';
        $collection
            ->getSelect()
            ->joinLeft(['address' => 'customer_address_entity'], 'address.parent_id = main_table.customer_id', ['address' => 'entity_id'])
            ->joinLeft(['address_varchar' => 'customer_address_entity_varchar'], "address_varchar.entity_id = address.entity_id
            AND address_varchar.attribute_id = ({$selectCountryAttributeId})", ['address_varchar' => 'value']);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $commonColumns = new SH_Telesign_Block_Telephone_Common();
        $commonColumns->prepareColumns($this);

        $this->addColumnAfter('verify_code',
            [
                'header' => $this->__('Verify Code'),
                'width'  => '50px',
                'index'  => 'verify_code',
            ],
            'notification_type'
        );

        $this->addColumnAfter('confirm_verify_code',
            [
                'header'  => $this->__('Verify Code - Is Confirmed?'),
                'width'   => '50px',
                'index'   => 'confirm_verify_code',
                'type'    => 'options',
                'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            ],
            'notification_type'
        );

        $this->addColumnAfter('created_at',
            [
                'header'  => $this->__('Created At'),
                'width'   => '50px',
                'index'   => 'created_at',
            ],
            'verify_code'
        );

        $this->addExportType('*/*/exportCsv', $this->__('CSV'));

        $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
    }

    protected function _prepareMassaction()
    {
        $modelPk = Mage::getModel('sh_telesign/transactions')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->addItem('delete', [
            'label' => $this->__('Delete'),
            'url'   => $this->getUrl('*/*/massDelete'),
        ]);

        return $this;
    }
}

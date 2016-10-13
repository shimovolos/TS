<?php

/**
 * Class SH_Telesign_Block_Telephone_Base_Grid
 */
class SH_Telesign_Block_Telephone_Base_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sh_telesign/telephone_base')->getCollection();

        $collection->getSelect()->joinLeft(['customer' => 'customer_entity'], 'customer.entity_id = main_table.customer_id', ['customer' => 'entity_id']);
        $collection->addFilterToMap('customer', '`customer`.`entity_id`');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('customer',
            [
                'header'   => $this->__('Customer'),
                'width'    => '50px',
                'index'    => 'customer',
                'renderer' => 'SH_Telesign_Block_Admin_Telephone_Renderer_Customer'
            ]
        );

        $this->addColumn('telephone',
            [
                'header' => $this->__('Telephone'),
                'width'  => '50px',
                'index'  => 'telephone',
            ]
        );

        $this->addColumn('notification_type',
            [
                'header' => $this->__('Notification Type'),
                'width'  => '50px',
                'index'  => 'notification_type',
            ]
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
        $modelPk = Mage::getModel('sh_telesign/telephone_base')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->addItem('delete', [
            'label' => $this->__('Delete'),
            'url'   => $this->getUrl('*/*/massDelete'),
        ]);

        return $this;
    }
}

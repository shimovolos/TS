<?php

/**
 * Class SH_Telesign_Block_Telephone_Common
 */
class SH_Telesign_Block_Telephone_Common extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @param $parent
     */
    public function prepareColumns($parent)
    {
        $parent->addColumn('entity_id',
            [
                'header' => $parent->__('ID'),
                'width'  => '50px',
                'index'  => 'entity_id',
            ]
        );

        $parent->addColumn('customer_id',
            [
                'header'                    => $parent->__('Customer'),
                'width'                     => '50px',
                'index'                     => 'customer_id',
                'frame_callback'            => [$this, 'callbackCustomerLink'],
                'filter_condition_callback' => [$this, 'callbackFilterCustomers'],
            ]
        );

        $parent->addColumn('customer_country',
            [
                'header'                    => $parent->__('Customer Country'),
                'width'                     => '50px',
                'index'                     => 'country_id',
                'frame_callback'            => [$this, 'callbackCustomerCountry'],
                'type'                      => 'options',
                'options'                   => $this->_getCountryList(),
                'filter_condition_callback' => [$this, 'callbackFilterCustomerCountry'],
            ]
        );

        $parent->addColumn('telephone',
            [
                'header' => $parent->__('Telephone'),
                'width'  => '50px',
                'index'  => 'telephone',
            ]
        );

        $parent->addColumn('notification_type',
            [
                'header'  => $parent->__('Notification Type'),
                'width'   => '50px',
                'index'   => 'notification_type',
                'type'    => 'options',
                'options' => Mage::getModel('sh_telesign/system_config_source_type_notification')
                    ->toArray(SH_Telesign_Model_System_Config_Source_Type_Notification::TELESIGN_TYPE_BOTH),
            ]
        );

        $parent->addColumn('action',
            [
                'header'   => $parent->helper('catalog')->__('Action'),
                'width'    => 15,
                'sortable' => false,
                'filter'   => false,
                'type'     => 'action',
                'getter'   => 'getId',
                'actions'  => [
                    [
                        'url'     => [
                            'base'   => '*/*/edit',
                            'params' => ['store' => $parent->getRequest()->getParam('store')],
                        ],
                        'caption' => $parent->helper('catalog')->__('Edit'),
                        'field'   => 'id',
                    ],
                ],
            ]
        );
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function callbackCustomerLink($value)
    {
        $customerId = $value;
        $customer = Mage::getModel('customer/customer')->load($customerId);

        $url = $this->getUrl('*/customer/edit', ['id' => $value]);
        $link = '<a href="' . $url . '">' . $customer->getName() . '</a>';

        return $link;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function callbackCustomerCountry($value, $row)
    {
        $customerId = $row->getCustomerId();
        $customerDefaultAddress = Mage::helper('sh_telesign/customer')
            ->getCustomerDefaultAddress(Mage::helper('sh_telesign')->addressTypeForTelephone(), $customerId);


        return $customerDefaultAddress->getCountryModel()->getName();
    }

    /**
     * @param $collection
     * @param $column
     *
     * @return $this
     */
    public function callbackFilterCustomers($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $this->getCollection()
            ->getSelect()
            ->joinLeft(['customer' => 'customer_entity_varchar'], 'customer.entity_id = main_table.customer_id')
            ->where("customer.value like ?", "%$value%");

        return $this;
    }

    /**
     * @param $collection
     * @param $column
     *
     * @return $this
     */
    public function callbackFilterCustomerCountry($collection, $column)
    {
        /* @var $column Mage_Adminhtml_Block_Widget_Grid_Column */
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $collection
            ->getSelect()
            ->where('address_varchar.value = ?', $value)
            ->order('main_table.entity_id ASC');

        return $collection;
    }

    /**
     * @return array
     */
    protected function _getCountryList()
    {
        $result = [];
        $apiItems = Mage::getModel('directory/country_api')->items();

        foreach ($apiItems as $items) {
            $result[$items['country_id']] = $items['name'];
        }

        ksort($result);

        return $result;
    }
}
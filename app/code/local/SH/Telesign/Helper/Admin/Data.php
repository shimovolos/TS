<?php

/**
 * Class SH_Telesign_Helper_Admin_Data
 */
class SH_Telesign_Helper_Admin_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @return bool
     */
    public function checkEnableTelephoneBaseGrid()
    {
        $isAvailableDataGrids = Mage::getStoreConfig('sh_telesign_admin_settgins/general/enable_data_grids');
        $isEnable = $isAvailableDataGrids && Mage::getStoreConfig('sh_telesign_admin_settgins/general/enable_telephone_base_data_grid');
        
        return $isEnable;
    }
}
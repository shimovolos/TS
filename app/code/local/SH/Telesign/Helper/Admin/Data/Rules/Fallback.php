<?php

/**
 * Class SH_Telesign_Helper_Admin_Rules_Fallback
 */
class SH_Telesign_Helper_Admin_Data_Rules_Fallback extends Mage_Core_Helper_Abstract
{
    /**
     * Fallback to resource parent node
     * @param $resourceId
     *
     * @return string
     */
    protected function _getParentResourceId($resourceId)
    {
        $resourcePathInfo = explode('/', $resourceId);
        array_pop($resourcePathInfo);
        return implode('/', $resourcePathInfo);
    }

    /**
     * Fallback resource permissions similarly to zend_acl
     * @param        $resources
     * @param        $resourceId
     * @param string $defaultValue
     *
     * @return string
     */
    public function fallbackResourcePermissions(
        &$resources,
        $resourceId,
        $defaultValue = Mage_Admin_Model_Rules::RULE_PERMISSION_DENIED
    ) {
        if (empty($resourceId)) {
            return $defaultValue;
        }

        if (!array_key_exists($resourceId, $resources)) {
            return $this->fallbackResourcePermissions($resources, $this->_getParentResourceId($resourceId));
        }

        return $resources[$resourceId];
    }
}
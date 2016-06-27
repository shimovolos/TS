<?php

/**
 * Class SH_Telesign_Helper_Verify
 */
class SH_Telesign_Helper_Verify extends Mage_Core_Helper_Abstract
{
    /**
     * @param $customerId
     * @param $verifyCode
     * @return bool
     */
    public function verifyCode($customerId, $verifyCode)
    {
        /** @var $transactionModel SH_Telesign_Model_Transactions */
        $transactionModel = Mage::getModel('sh_telesign/transactions')->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->getFirstItem();

        if (!$transactionModel->getData('confirm_verify_code')) {
            $isVerify = ($transactionModel->getData('verify_code') == $verifyCode);

            $login = $isVerify ? true : false;

            if ($isVerify) {
                $transactionModel->confirmTransactionVerifyCode($verifyCode);
            }
        } else {
            $login = true;
        }

        return $login;
    }

    /**
     * @param $customerId
     * @return bool
     */
    public function checkConfirmationVerifyCode($customerId)
    {
        /** @var $transactionModel SH_Telesign_Model_Transactions */
        $transactionModel = Mage::getModel('sh_telesign/transactions')->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('confirm_verify_code', true)
            ->getFirstItem();

        return $transactionModel->isEmpty();
    }
}
<?php

/**
 * Class SH_Telesign_Model_Transactions
 */

/**
 * @method string getNotificationType()
 * @method SH_Telesign_Model_Transactions setNotificationType(string $value)
 * @method string getResendCode()
 * @method SH_Telesign_Model_Transactions setResendCode(string $value)
 * @method int getTransactionCode()
 * @method SH_Telesign_Model_Transactions setTransactionCode(int $value)
 * @method string getConfirmVerifyCode()
 * @method SH_Telesign_Model_Transactions setConfirmVerifyCode(string $value)
 * @method string getCreatedAt()
 * @method SH_Telesign_Model_Transactions setCreatedAt(string $value)
 * @method string getTelephone()
 * @method SH_Telesign_Model_Transactions setTelephone(string $value)
 * @method int getVerifyCode()
 * @method SH_Telesign_Model_Transactions setVerifyCode(int $value)
 * @method int getEntityId()
 * @method SH_Telesign_Model_Transactions setEntityId(int $value)
 * @method int getCustomerId()
 * @method SH_Telesign_Model_Transactions setCustomerId(int $value)
 */
class SH_Telesign_Model_Transactions extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('sh_telesign/transactions');
    }

    /**
     * @param null $data
     * @throws Mage_Core_Exception
     */
    public function saveTransaction($data = null)
    {
        if($data) {
            /** @var $transactionModel SH_Telesign_Model_Transactions */

            $this->setData([
                'customer_id'        => $data['customer_id'],
                'telephone'          => $data['telephone'],
                'notification_type'  => $data['notification_type'],
                'notification_label' => $data['notificationLabel'],
                'created_at'         => now(),
            ]);

            try {
                $this->save();
            } catch (Exception $e) {
                Mage::throwException($e->getMessage());
            }
        }
    }

    /**
     * @throws Mage_Core_Exception
     */
    public function confirmTransactionVerifyCode()
    {
        $this->setData('confirm_verify_code', true);

        try {
            $this->save();
        } catch (Exception $e) {
            Mage::throwException($e->getMessage());
        }
    }

    /**
     * @param $telephone
     * @throws Mage_Core_Exception
     */
    public function updateTransactionResendPhone($telephone)
    {
        $this->setData('telephone', $telephone);

        try {
            $this->save();
        } catch (Exception $e) {
            Mage::throwException($e->getMessage());
        }
    }

    public function updateTransactionResendCode()
    {
        //toDo update transaction model after Re-send verify code
    }
}
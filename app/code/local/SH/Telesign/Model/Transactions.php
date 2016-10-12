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
    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $transCodes = array(
        300 => 'Transaction successfully completed. The system was able to obtain all of the requested data.',
        301 => 'Transaction partially completed. The system was able to obtain some of the data, but not all of it.',
        500 => 'Transaction not attempted. No Call or SMS request was attempted.',
        501 => 'Not authorized. No permissions for this resource, or authorization failed.',
        599 => 'Status not available. The system is unable to provide status at this time.'
    );

    /**
     * @var array
     */
    protected $smsCodes = array(
        200 => 'Delivered to handset. SMS has been delivered to the user\'s phone.',
        203 => 'Delivered to gateway. SMS has been delivered to the gateway. If the gateway responds with further information (including successful delivery to handset or delivery failure), the status is updated.',
        207 => 'Error delivering SMS to handset (reason unknown). SMS could not be delivered to the user\'s handset for an unknown reason.',
        210 => 'Temporary phone error. SMS could not be delivered to the handset due to a temporary error with the phone. Examples: phone is turned off, not enough memory to store the message.',
        211 => 'Permanent phone error. SMS could not be delivered to the handset due to a permanent error with the phone. For example, phone is incompatible with SMS, or phone is illegally registered on the network.',
        220 => 'Gateway/network cannot route message. Network cannot route the message to the handset. This can happen when a phone number is blacklisted on the network or is not a valid phone number.',
        221 => 'Message expired before delivery. The message was queued by the mobile provider and timed out before it could be delivered to the handset.',
        222 => 'SMS not supported. SMS is not supported by this phone, carrier, plan, or user.',
        229 => 'Message blocked by customer request. TeleSign blocked the SMS before it was sent. This is due to your prior submitted request to blocklist this phone number.',
        230 => 'Message blocked by TeleSign. TeleSign blocked the SMS before it was sent. This can happen if the message contains spam or inappropriate material or if TeleSign believes the client is abusing the account in any way.',
        231 => 'Invalid/unsupported message content. The content of the message is not supported.',
        250 => 'Final status unknown. The final status of the message cannot be determined.',
        290 => 'Message in progress. The message is being sent to the SMS gateway.',
        291 => 'Queued by TeleSign. TeleSign is experiencing unusually high volume and has queued the SMS message.',
        292 => 'Queued at gateway. The SMS gateway has queued the message.',
        295 => 'Status delayed. The status of the SMS is temporarily unavailable.',
        500 => 'Transaction not attempted. No Call, SMS, or PhoneID request was attempted.',
        501 => 'Not authorized. No permissions for this resource, or authorization failed.',
        599 => 'Status not available. The system is unable to provide status at this time.',
    );

    /**
     * @var array
     */
    protected $callCodes = array(
        100 => 'Call answered. The call was answered.',
        101 => 'Not answered. The call was not answered.',
        102 => 'Disconnect occurred before message completed. The call was disconnected before the voice message finished.',
        103 => 'Call in progress. TeleSign is either making the call or playing the voice message.',
        104 => 'Wrong/invalid phone number. The phone number is either incorrect, or it is not a valid phone number.',
        105 => 'Call not handled yet. The verification call has not yet been attempted.',
        106 => 'Call failed. An error occurred. No further attempt to call will be made.',
        107 => 'Line busy. The line is busy.',
        129 => 'Call blocked by customer request. TeleSign blocked the call before it was placed. This is due to your prior submitted request to blocklist this phone number.',
        130 => 'Call blocked by TeleSign. TeleSign blocked the phone call. This can happen if the message contains inappropriate material, or if TeleSign believes the client is abusing the service.',
        500 => 'Transaction not attempted. No Call, SMS, or PhoneID request was attempted.',
        501 => 'Not authorized. No permissions for this resource, or authorization failed.',
        599 => 'Status not available. The system is unable to provide status at this time.',
    );

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

    /**
     * @param $code - $response['status']['code']
     * @param $type
     * @return mixed
     */
    public function getTransactionMsg($code, $type)
    {
        if (!empty($code)) {
            if($type == SH_Telesign_Model_System_Config_Source_Type_Notification::TELESIGN_TYPE_PHONE_VERIFICATION) {
                $this->message = $this->transCodes[$code];
            } elseif ($type == SH_Telesign_Model_System_Config_Source_Type_Notification::TELESIGN_TYPE_SMS) {
                $this->message = $this->smsCodes[$code];
            } elseif($type == SH_Telesign_Model_System_Config_Source_Type_Notification::TELESIGN_TYPE_CALL) {
                $this->message = $this->callCodes[$code];
            }

            return $this->message;
        } else {
            return end($this->transCodes);
        }
    }
}
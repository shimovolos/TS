<?php

/**
 * Class SH_Telesign_Model_Telesign_Verify
 */
class SH_Telesign_Model_Telesign_Verify extends SH_Telesign_Model_Telesign_Core
{
    /**
     * The Telesign Voice Verify product includes the Verify Call web service, which sends a verification code to your end user in a voice message with a phone call.
     *
     * @link https://developer.telesign.com/docs/rest_api-verify-call
     *
     * @param $telephone
     * @param string $verifyCode
     * @param string $language
     * @param string $verifyMethod
     * @param string $extensionType
     * @param string $extensionTemplate
     * @param string $redial
     * @param array $data
     * @return string
     */
    public function call($telephone, $verifyCode = '', $language = '', $verifyMethod = '', $extensionType = '', $extensionTemplate = '', $redial = '', $data = array())
    {

        $data['language'] = $language ? $language : $data['language'];
        $data['verify_method'] = $verifyMethod ? $verifyMethod : $data['verify_method'];
        $data['extension_type'] = $extensionType ? $extensionType : $data['extension_type'];
        $data['extension_template'] = $extensionTemplate ? $extensionTemplate : $data['extension_template'];
        $data['redial'] = $redial ? $redial : $data['redial'];

        if (!empty(Mage::helper('sh_telesign/api_settings')->apiCallTextToSpeechTemplate())) {
            $data['tts_message'] = Mage::helper('sh_telesign/api_settings')->apiCallTextToSpeechTemplate();
        }

        return $this->verify($telephone, $verifyCode, 'call', $data);
    }

    /**
     * The SMS Verify product includes the Verify SMS web service, which sends a verification code to your end user in a text message.
     *
     * @link https://developer.telesign.com/docs/rest_api-verify-sms
     * @param $telephone
     * @param string $verifyCode
     * @param string $language
     * @return mixed
     */
    public function sms($telephone, $verifyCode = '', $language = '')
    {
        $data = array();

        if (!empty($language)) {
            $data['language'] = $language;
        }
        if (!empty(Mage::helper('sh_telesign/api_settings')->apiSmsTemplate())) {
            $data['template'] = Mage::helper('sh_telesign/api_settings')->apiSmsTemplate();
        }
        return $this->verify($telephone, $verifyCode, 'sms', $data);
    }

    /**
     * @link https://developer.telesign.com/docs/rest_api-verify-transaction-callback
     *
     * @param $reference
     * @param string $verifyCode
     * @return mixed
     */
    public function status($reference, $verifyCode = '')
    {

        $resource = "/v1/verify/" . $reference;
        $url = $this->apiUrl. $resource . (strlen($verifyCode) ? ("?verify_code=" . $verifyCode) : "");
        $this->curl->addOption(CURLOPT_URL, $url);

        $this->method = "GET";
        $this->contentType = "text/plain";

        $this->_sign($resource);
        return json_decode($this->_submitAndGetResponse(), true);
    }
}
<?php

/**
 * Class SH_Telesign_Model_Telesign_Core
 */

class SH_Telesign_Model_Telesign_Core extends Mage_Core_Model_Abstract
{
    const TELESIGN_AUTH_METHOD = 'hmac-sha1';
    const TELESIGN_API_URL = 'https://rest.telesign.com';
    const TELESIGN_USER_AGENT = 'TelesignSDK/php1.0';
    /**
     * @var Varien_Http_Adapter_Curl
     */
    protected $curl;

    /**
     * @var
     */
    protected $method;

    /**
     * @var
     */
    protected $contentType;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var array|string
     */
    protected $curlHeaders;

    /**
     * @var array
     */
    protected $postVariables;

    /**
     * @var string
     */
    protected $rawResponse;

    /**
     * @var int
     */
    protected $curlErrorNum;

    /**
     * @var string
     */
    protected $curlErrorDescription;

    protected $customerId;
    protected $secretKey;
    protected $authMethod;
    protected $apiUrl;

    /**
     * Telesign API
     * @param Varien_Object $params
     *
     * @link https://developer.telesign.com/docs/authentication-1
     */
    public function __construct(Varien_Object $params)
    {

        $this->customerId = Mage::helper('sh_telesign/api_settings')->apiCustomerId();
        $this->secretKey = base64_decode(Mage::helper('sh_telesign/api_settings')->apiRestKey());

        $this->authMethod = $params->getData('auth_method') ? $params->getData('auth_method') : self::TELESIGN_AUTH_METHOD;
        $this->apiUrl = $params->getData('api_url') ? $params->getData('api_url') : self::TELESIGN_API_URL;
        $this->timestamp = time();

        $this->curl = new Varien_Http_Adapter_Curl();

        //toDo add local ssl certificate for curl and remove CURLOPT_SSL_VERIFYPEER + CURLOPT_SSL_VERIFYHOST
        $this->curl->addOption(CURLOPT_SSL_VERIFYPEER, false);
        $this->curl->addOption(CURLOPT_SSL_VERIFYHOST, false);

        $this->curl->addOption(CURLOPT_TIMEOUT, $params->getData('request_timeout') ? $params->getData('request_timeout') : 5);
        $this->curl->addOption(CURLOPT_RETURNTRANSFER, true);
        $this->curl->addOption(CURLOPT_USERAGENT, self::TELESIGN_USER_AGENT);

        foreach ($params->getData('curl_options') as $option => $value) {
            $this->curl->addOption($option, $value);
        }

        $this->curlHeaders = $params->getData('headers');
        $this->postVariables = array();
        $this->rawResponse = '';
        $this->curlErrorNum = -1;
        $this->curlErrorDescription = '';
    }

    /**
     * Create Authorization Header
     *
     * @param string $resource (Telesign service).
     * @param string $post
     */
    protected function _sign($resource, $post = '')
    {

        $xTsNonce = uniqid();
        $xTsDate = date("D, j M Y H:i:s O", $this->timestamp);
        $xTsHeaders = "x-ts-auth-method:" . $this->authMethod . "\n" .
            "x-ts-date:" . $xTsDate . "\n" .
            "x-ts-nonce:" . $xTsNonce;

        $this->curlHeaders['X-TS-Auth-Method'] = $this->authMethod;
        $this->curlHeaders['X-TS-Date'] = $xTsDate;
        $this->curlHeaders['X-TS-Nonce'] = $xTsNonce;
        $this->curlHeaders['Content-Type'] = $this->contentType;

        $signature =
            $this->method . "\n" .
            $this->contentType . "\n" .
            "\n" .
            $xTsHeaders . "\n" .
            (isset($post) ? ($post . "\n") : "") .
            $resource;

        $signature = base64_encode(hash_hmac(substr($this->authMethod, 5), $signature, $this->secretKey, true));

        $this->curlHeaders['Authorization'] = "TSA " . $this->customerId . ":" . $signature;
    }

    /**
     * Submit post data to service url and get response
     *
     * @param string $post
     * @return string Raw data receive from service
     */
    protected function _submitAndGetResponse($post = '')
    {
        $headers = array();
        foreach ($this->curlHeaders as $name => $value) {
            $headers[] = $name . ": " . $value;
        }

        $this->curl->addOption(CURLOPT_HTTPHEADER, $headers);

        if ($post) {
            $this->curl->addOption(CURLOPT_POST, true);
            $this->curl->addOption(CURLOPT_POSTFIELDS, $post);
        } else {
            $this->curl->addOption(CURLOPT_POST, false);
        }

        $this->rawResponse = $this->curl->read();
        $this->curlErrorNum = $this->curl->getErrno();
        $this->curlErrorDescription = $this->curl->getError();

        if ($this->curlErrorNum) {
            return '';
        }

        return $this->rawResponse;
    }

    /**
     * General verify function
     *
     * @param $telephone
     * @param $verifyCode
     * @param string $service
     * @param array $data
     *
     * @return mixed
     */
    public function verify($telephone, $verifyCode, $service = "call", $data = array())
    {

        $post = "phone_number=" . str_replace('+', '', $telephone) . "&" . ($verifyCode ? ("verify_code=" . $verifyCode . "&") : "");
        foreach ($data as $argument => $value) {
            $post .= $argument . "=" . urlencode($value) . "&";
        }

        //replace last '&'
        $post = substr($post, 0, -1);

        $resource = "/v1/verify/" . $service;
        $url = $this->apiUrl . $resource;
        $this->curl->addOption(CURLOPT_URL, $url);

        $this->method = "POST";
        $this->contentType = "application/x-www-form-urlencoded";

        $this->curl->connect($url);
        $this->_sign($resource, $post);
        return json_decode($this->_submitAndGetResponse($post), true);
    }

    /**
     * The PhoneID Standard web service returns the following information about a specified phone number: type, numbering structure, cleansing details, location
     *
     * @link https://developer.telesign.com/docs/rest_phoneid-standard
     *
     * @param $telephone
     * @param string $service
     * @param array $data
     * @return mixed
     */
    public function phoneId($telephone, $service = "standard", $data = array())
    {

        $resource = "/v1/phoneid/" . $service . "/" . $telephone;
        $url = $this->apiUrl . $resource;
        if ($data) {
            $url .= "?";
            foreach ($data as $argument => $value) {
                $url .= $argument . "=" . urlencode($value) . "&";
            }

            $url = substr($url, 0, -1);
        }

        $this->curl->addOption(CURLOPT_URL, $url);

        $this->method = "GET";
        $this->contentType = "text/plain";

        $this->_sign($resource);
        return json_decode($this->_submitAndGetResponse(), true);
    }

    /**
     * Return a reference to the curl object
     *
     * @return object The curl object
     */
    public function getCurl()
    {
        return $this->curl;
    }

    /**
     * Return curl execution error numbers
     *
     * @return int
     */
    public function getCurlErrorNumber()
    {
        return $this->curlErrorNum;
    }

    /**
     * Return curl error message
     *
     * @return string
     */
    public function getCurlErrorMessage()
    {
        return $this->curlErrorDescription;
    }

    /**
     * Return http status after execution
     *
     * @return string
     */
    public function getHttpStatus()
    {

        if ($this->curlErrorNum) {
            return 0;
        }

        return $this->curl->getInfo(CURLINFO_HTTP_CODE);
    }
}
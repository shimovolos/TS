<?php

/**
 * Class SH_Telesign_Model_Telesign_PhoneId
 */
class SH_Telesign_Model_Telesign_PhoneId extends SH_Telesign_Model_Telesign_Core
{
    /**
     * @link https://developer.telesign.com/docs/rest_phoneid-standard
     * @param $telephone
     * @return mixed
     */
    public function standard($telephone)
    {
        return $this->phoneid($telephone, "standard");
    }

    /**
     * The Score web service provides risk information about a specified phone number.
     *
     * @link https://developer.telesign.com/docs/rest_api-phoneid-score
     *
     * @param $telephone
     * @param $ucid (Telesign Use Case Code)
     * @return mixed
     */
    public function score($telephone, $ucid)
    {
        return $this->phoneid($telephone, "score", ["ucid" => $ucid]);
    }

    /**
     * The PhoneID Contact web service provides contact details for a specified phone number’s subscriber.
     * @link https://developer.telesign.com/docs/rest_api-phoneid-contact
     *
     * @param $telephone
     * @param $ucid (Telesign Use Case Code)
     * @return mixed
     */
    public function contact($telephone, $ucid)
    {
        return $this->phoneid($telephone, "contact", ["ucid" => $ucid]);
    }

    /**
     * The PhoneID Live web service provides information about a specified phone number’s state of operation.
     * @link https://developer.telesign.com/docs/rest_api-phoneid-live
     *
     * @param $telephone
     * @param $ucid (Telesign Use Case Code)
     * @return mixed
     */
    public function live($telephone, $ucid) {
        return $this->phoneid($telephone, "live", ["ucid" => $ucid]);
    }
}
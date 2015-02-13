<?php

namespace JeroenDesloovere\Wunderlist;

/*
 * This file is part of the Wunderlist PHP class from Jeroen Desloovere.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use JeroenDesloovere\Wunderlist\Exception;
use JeroenDesloovere\Wunderlist\Objects\Authorization;
use JeroenDesloovere\Wunderlist\Objects\Lists;
use JeroenDesloovere\Wunderlist\Objects\Tasks;

/**
 * Wunderlist
 *
 * This Wunderlist PHP Class connects to the Wunderlist API.
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */
class Wunderlist
{
    // API URL
    const API_URL = 'https://a.wunderlist.com/api';

    // API version
    const API_VERSION = 'v1';

    // OAUTH URL
    const OAUTH_URL = 'https://www.wunderlist.com/oauth/authorize';

    /**
     * Access token
     *
     * @var string
     */
    private $accessToken;

    /**
     * The curl connection
     *
     * @var string
     */
    private $curl;

    /**
     * The client id that will be used for authenticating
     *
     * @var string
     */
    private $clientId;

    /**
     * The client secret that you received when registering in Wunderlist.
     *
     * @var string
     */
    private $clientSecret;

    /**
     * Constructs the Wunderlist API
     *
     * @param  string $clientId
     * @param  string $clientSecret
     * @param  string $accessToken
     * @return void
     */
    public function __construct(
        $clientId,
        $clientSecret,
        $accessToken = null
    ) {
        // define credentials
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);

        // we have no access token, the user first needs to obtain this
        // using ->authorize($redirectUrl); on the server
        if ($this->accessToken !== null) {
            // define access token
            $this->setAccessToken($accessToken);

            // prepare our connection
            $this->prepareConnection();
        }

        // add all public variables
        $this->authorization = new Authorization($this);
        $this->lists = new Lists($this);
        $this->tasks = new Tasks($this);
    }

    /**
     * Call a certain method with its parameters
     *
     * @param  string $endPoint
     * @param  string $parameters[optional]
     * @param  string $method[optional]
     * @return false  or array
     */
    public function doCall(
        $endPoint,
        $parameters = array(),
        $method = 'GET'
    ) {
        if ($this->getAccessToken() === null) {
            throw new Exception('First you need to obtain an Access Token by executing $api->authorize($redirectUrl);');
        }

        // define url
        $url = self::API_URL . '/' . self::API_VERSION . '/' . $endPoint;

        // set options
        curl_setopt($this->curl, CURLOPT_URL, $url);

        // parameters are set
        if (!empty($parameters)) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($parameters));
        }

        // method is POST, used for login or inserts
        if ($method == 'POST') {
            // define post method
            curl_setopt($this->curl, CURLOPT_POST, true);
        // method is DELETE
        } elseif ($method == 'DELETE') {
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        // execute
        $response = curl_exec($this->curl);

        // get HTTP response code
        $httpCode = (int) curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        // close
        curl_close($this->curl);

        // response is empty or false
        if (empty($response)) {
            throw new Exception('Error: ' . serialize($response));
        }

        // init result
        $result = false;

        // successfull response
        if (($httpCode == 200) || ($httpCode == 201)) {
            $result = json_decode($response, true);
        }

        // return
        return $result;
    }

    /**
     * Get access token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get client id
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Get client secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Prepare connection
     */
    private function prepareConnection()
    {
        // check if curl is available
        if (!function_exists('curl_init')) {
            throw new Exception(
                'This method requires cURL (http://php.net/curl), it seems like the extension isn\'t installed.'
            );
        }

        // init headers
        $headers = array();

        // add to header
        $headers[] = 'X-Client-ID: ' . $this->getClientId();
        $headers[] = 'X-Access-Token: ' . $this->getAccessToken();

        // init curl
        $this->curl = curl_init();

        // set options for curl
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 10);
    }

    /**
     * Set access token
     *
     * @param string $value
     */
    public function setAccessToken($value)
    {
        $this->accessToken = (string) $value;
    }

    /**
     * Set client id
     *
     * @param string $value
     */
    public function setClientId($value)
    {
        $this->clientId = (string) $value;
    }

    /**
     * Set client secret
     *
     * @param string $value
     */
    public function setClientSecret($value)
    {
        $this->clientSecret = (string) $value;
    }
}

<?php

namespace JeroenDesloovere\Wunderlist;

/*
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

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
    const API_URL = 'https://api.wunderlist.com';

    // internal constant to enable/disable debugging
    const DEBUG = false;

    // current class version
    const VERSION = '1.0.0';

    /**
     * Authorization token
     *
     * @var string
     */
    protected $authToken;

    /**
     * The password that will be used for authenticating
     *
     * @var string
     */
    protected $password;

    /**
     * The username/email that will be used for authenticating
     *
     * @var string
     */
    protected $username;

    /**
     * Constructs the Wunderlist API
     *
     * @param  string $username
     * @param  string $password
     * @return void
     */
    public function __construct($username, $password)
    {
        // define credentials
        $this->username = (string) $username;
        $this->password = (string) $password;

        // authenticate credentials
        $this->authenticate();
    }

    /**
     * Authenticate credentials by logging in
     */
    protected function authenticate()
    {
        // init parameters
        $parameters = array();

        // build parameters
        $parameters['email'] = $this->username;
        $parameters['password'] = $this->password;

        // login to check if credentials are correct
        $response = $this->doCall('login', $parameters, 'POST');

        if ($response) {
            // define authorization token
            $this->authToken = $response['token'];
        } else {
            // error
            throw new WunderlistException('Could not Authenticate.');
        }
    }

    /**
     * Call a certain method with its parameters
     *
     * @param  string $endPoint
     * @param  string $parameters
     * @return false  or array
     */
    protected function doCall($endPoint, $parameters = array(), $method = 'GET')
    {
        // check if curl is available
        if (!function_exists('curl_init')) {
            throw new WunderlistException('This method requires cURL (http://php.net/curl), it seems like the extension isn\'t installed.');
        }

        // define url
        $url = self::API_URL . '/' . $endPoint;

        // init curl
        $curl = curl_init();

        // set options
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        // init headers
        $headers = array();

        // we have an authorization token
        if (!empty($this->authToken)) {
            // add to header
            $headers[] = 'authorization: Bearer ' . $this->authToken;
        }

        // define headers with the request
        if (!empty($headers)) {
            // add headers
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        // parameters are set
        if (!empty($parameters)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameters) );
        }

        // method is POST, used for login
        if ($method == 'POST') {
            // define post method
            curl_setopt($curl, CURLOPT_POST, true);
        }

        // execute
        $response = curl_exec($curl);

        // get HTTP response code
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // close
        curl_close($curl);

        // response is empty or false
        if (empty($response)) {
            throw new WunderlistException('Error: ' . $response);
        }

        // init result
        $result = false;

        // successfull response
        if (($httpCode == 200) || ($httpCode == 201)) {
            $result = json_decode($response, true);
        }

        // return
        return $result;

        /*
        // Set request type for PUT
        if ( strtolower($endPoint) == 'put' ) {
            // Set custom request to put
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

            // Data needs to be send as json
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data) );

            // Set header content-type to application/json
            $headers[] = 'content-type: application/json';

            // Set header Content-Lenght to the json encoded length
            $headers[] = 'Content-Length: '.strlen(json_encode($data));
        }

        // Set request type for DELETE
        if ( strtolower($endPoint) == 'delete' ) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        // Files
        if ( strpos($action, "/files") ) {
            $headers[] = "Accept: application/json";
            $headers[] = "Accept-Encoding: gzip, deflate";
            $headers[] = "Accept-Language: nl,en-us;q=0.7,en,q=0.3";
            $headers[] = "Content-Type: application/json; charset=utf-8";
            $headers[] = "Host: files.wunderlist.com";
            $headers[] = "Origin: https://www.wunderlist.com";
            $headers[] = "Referer: https://www.wunderlist.com";
            $headers[] = "X-6W-Platform: web";
            $headers[] = "X-6W-Product: wunderlist";
            $headers[] = "X-6W-System: MacIntel";
        }
        */
    }

    /**
     * Get events
     *
     * @return array
     */
    public function getEvents()
    {
        return $this->doCall('me/events');
    }

    /**
     * Get friends
     *
     * @return array
     */
    public function getFriends()
    {
        return $this->doCall('me/friends');
    }

    /**
     * Get a list
     *
     * @param  string $listId
     * @return array
     */
    public function getList($listId)
    {
        return $this->doCall('me/' . $listId);
    }

    /**
     * Get shares for a list
     *
     * @param  string $listId
     * @return array
     */
    public function getListShares($listId)
    {
        return $this->doCall('me/' . $listId . '/shares');
    }

    /**
     * Get lists
     *
     * @return array
     */
    public function getLists()
    {
        return $this->doCall('me/lists');
    }

    /**
     * Get profile from user
     *
     * @return array
     */
    public function getProfile()
    {
        return $this->doCall('me');
    }

    /**
     * Get quota
     *
     * @return array
     */
    public function getQuota()
    {
        return $this->doCall('me/quota');
    }

    /**
     * Get reminders
     *
     * @return array
     */
    public function getReminders()
    {
        return $this->doCall('me/reminders');
    }

    /**
     * Get services
     *
     * @return array
     */
    public function getServices()
    {
        return $this->doCall('me/services');
    }

    /**
     * Get shares
     *
     * @return array
     */
    public function getShares()
    {
        return $this->doCall('me/shares');
    }

    /**
     * Get settings
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->doCall('me/settings');
    }

    /**
     * Get a task
     *
     * @param  string $taskId
     * @return array
     */
    public function getTask($taskId)
    {
        return $this->doCall('me/' . $taskId);
    }

    /**
     * Get messages for a task
     *
     * @param  string $taskId
     * @return array
     */
    public function getTaskMessages($taskId)
    {
        return $this->doCall('me/' . $taskId . '/messages');
    }

    /**
     * Get tasks
     *
     * @return array
     */
    public function getTasks()
    {
        return $this->doCall('me/tasks');
    }

    /**
     * Get tasks from inbox
     *
     * @return array
     */
    public function getTasksFromInbox()
    {
        return $this->doCall('inbox/tasks');
    }
}

/**
 * Wunderlist Exception
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */
class WunderlistException extends \Exception {}

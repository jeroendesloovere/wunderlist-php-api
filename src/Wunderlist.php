<?php

namespace JeroenDesloovere\Wunderlist;

/*
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use JeroenDesloovere\Wunderlist\Exception as WunderlistException;

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
     * Delete list
     *
     * @param  string $listId
     * @return bool
     */
    public function deleteList($listId)
    {
        // delete list
        $result = $this->doCall($listId, null, 'DELETE');

        // if delete was successfull an empty result is return
        return (is_array($result) && count($result) == 0);
    }

    /**
     * Delete task
     *
     * @param  string $taskId
     * @return bool
     */
    public function deleteTask($taskId)
    {
        // delete list
        $result = $this->doCall($taskId, null, 'DELETE');

        // if delete was successfull an empty result is return
        return (is_array($result) && count($result) == 0);
    }

    /**
     * Call a certain method with its parameters
     *
     * @param  string $endPoint
     * @param  string $parameters[optional]
     * @param  string $method[optional]
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

        // method is POST, used for login or inserts
        if ($method == 'POST') {
            // define post method
            curl_setopt($curl, CURLOPT_POST, true);
        // method is DELETE
        } elseif ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        // execute
        $response = curl_exec($curl);

        // debug is on
        if (self::DEBUG) {
            echo $url . '<br/>';
            print_r($response);
            echo '<br/><br/>';
        }

        // get HTTP response code
        $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // close
        curl_close($curl);

        // response is empty or false
        if (empty($response)) {
            throw new WunderlistException('Error: ' . $response);
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
     * Get settings
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->doCall('me/settings');
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

    /**
     * Insert list
     *
     * @param  string $title
     * @return array
     */
    public function insertList($title)
    {
        // init parameters
        $parameters = array();

        // build parameters
        $parameters['title'] = (string) $title;

        // insert list
        return $this->doCall('me/lists', $parameters, 'POST');
    }

    /**
     * Insert task
     *
     * @param  string $title
     * @param  string $listId
     * @param  string $parentId[optional]
     * @param  string $dueDate[optional]
     * @param  bool   $starred[optional]
     * @return array
     */
    public function insertTask($title, $listId, $parentId = null, $dueDate = null, $starred = false)
    {
        // init parameters
        $parameters = array();

        // build parameters
        $parameters['title'] = (string) $title;
        $parameters['list_id'] = (string) $listId;
        $parameters['starred'] = ((bool) $starred) ? 1 : 0;

        // we have a parent id
        if ($parentId !== null) {
            // add to parameters
            $parameters['parent_id'] = $parentId;
        }

        // we have a due date
        if ($dueDate !== null) {
            // is no time
            if (!strtotime($dueDate)) {
                // throw error
                throw new WunderlistException('Parameters dueDate is invalid.');
            }

            // add parameter
            $parameters['due_date'] = date('Y-m-d', strtotime($dueDate));
        }

        // return insert task
        return $this->doCall('me/tasks', $parameters, 'POST');
    }
}
